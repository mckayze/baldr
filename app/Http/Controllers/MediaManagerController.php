<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MediaManagerController extends Controller
{
    public $space_replace_character = '_';
    public $ignore = ['public/.gitignore', '.gitignore'];

    private $base_path = 'public';
    private $post_max_size;
    private $upload_max_size;

    public function __construct()
    {
        $this->post_max_size   = ini_get('post_max_size');
        $this->upload_max_size = ini_get('upload_max_filesize');
    }

    /**
     * Core Functions
     *
     */

    public function getFilesAndFolders()
    {
        (Request::input('path') != null && Request::input('path') != '/')
            ? $path = Request::input('path')
            : $path = $this->base_path;

        $all_files = [];
        $all_directories = [];

        foreach(Storage::files($path) as $file)
        {
            // Check for ignored words / phrases are kept in here.
            foreach($this->ignore as $ignore)
            {
                if(strpos($file, $ignore))
                {
                    continue 2;
                }
            }

            $all_files[] = [
                'name' => str_replace('/', '', str_replace($path.'/', '', $file)),
                'mime' => Storage::mimeType($file),
                'size' => Storage::size($file),
                'path' => $file,
                'extension' => File::extension($file),
                'is_file' => true
            ];
        }

        foreach(Storage::directories($path) as $directory)
        {
            $all_directories[] = [
                'name' => str_replace('/', '', str_replace($path.'/', '', $directory)),
                'mime' => Storage::mimeType($directory),
                'size' => $this->getDirectoryFilesSize($directory),
                'path' => $directory,
                'is_file' => false
            ];
        }

        return [
            'paths'           => $this->getAllPaths($path),
            'current_path'    => $path,
            'all_files'       => $all_files,
            'all_directories' => $all_directories,
            'every_directory' => $this->getDirectoriesList()
        ];
    }

    public function upload()
    {
        $files = Request::allFiles()['files'];

        $current_path = Request::input('current_path');

        foreach ($files as $file)
        {
            $name = $this->replaceSpaces($file->getClientOriginalName());
//            $size = $file->getSize();
//            $mime = $file->getMimeType();
//            $extension = $file->getClientOriginalExtension();

            try {
                Storage::putFileAs($current_path, $file, $name);
            } catch(FileException $e)
            {
                echo $e->getMessage();
            }
        }

        return [
            'status' => 200,
            'statusText' => 'successfully uploaded file.'
        ];
    }

    public function createFolder()
    {
        $current_path = Request::input('current_path');
        $folder_name  = Request::input('name');

        if(Storage::exists($current_path.'/'.$folder_name))
        {
            return [
                'status'     => 500,
                'statusText' => 'A folder with that name already exists'
            ];
        }

        Storage::makeDirectory($current_path.'/'.$folder_name);
    }

    public function rename()
    {
        $path = Request::input('current_path');
        $new_name     = Request::input('new_name');
        $old_name     = Request::input('old_name');

        if($this->isDirectory($path, $old_name)){
            try {
                Storage::move($path.'/'.$old_name, $path.'/'.$new_name);
            } catch(\Exception $e)
            {
                return [
                    'status'     => 500,
                    'statusText' => $e->getMessage()
                ];
            }
        } else {
            $extension = '.'.File::extension($path.'/'.$old_name);

            try {
                Storage::move($path.'/'.$old_name, $path.'/'.$new_name.$extension);
            } catch(\Exception $e)
            {
                return [
                    'status'     => 500,
                    'statusText' => $e->getMessage()
                ];
            }
        }

        return [
            'status' => 200,
            'statusText' => 'Successfully renamed item/s'
        ];
    }

    public function move()
    {
        $desired_path = Request::input('desired_path');
        $current_path = Request::input('current_path');

        // For folders specifically
        if($desired_path === $current_path){
            return [
                'status' => 500,
                'statusText' => 'An item with the same name already exists at the chosen path'
            ];
        }

        // Check all to see if any are trying to be moved into themselves first
        foreach(Request::input('selected') as $file){
            if(strpos($desired_path, $file['path']) !== false)
            {
                return [
                    'status' => 500,
                    'statusText' => 'Cannot move folder within itself, please check and try again'
                ];
            }
        }

        // Only allow all files to be moved once verification has been done
        foreach(Request::input('selected') as $file)
        {
            $new_path = $desired_path.'/'.$file['name'];

            try {
                Storage::move($file['path'], $new_path);
            } catch(\Exception $e)
            {
                return [
                    'status' => 500,
                    'statusText' => $e->getMessage()
                ];
            }
        }

        return [
            'status' => 200,
            'statusText' => 'Successfully moved all files to desired location'
        ];
    }

    public function delete()
    {
        $path = Request::input('current_path');

        foreach(Request::input('selected') as $item)
        {
            if(Storage::exists($path.'/'.$item['name']))
            {
                if($item['is_file'])
                {
                    Storage::delete($path.'/'.$item['name']);
                } else {
                    Storage::deleteDirectory($path.'/'.$item['name']);
                }
            }
        }

        return [
            'status'     => 200,
            'statusText' => 'Successfully deleted all items!'
        ];
    }

    /**
     * Helper Functions
     */

    private function replaceSpaces($name)
    {
        return str_replace(' ', $this->space_replace_character, $name);
    }

    private function getDirectoryFilesSize($directory)
    {
        $total_bytes = 0;

        foreach(Storage::allFiles($directory) as $file)
        {
            $total_bytes += Storage::size($file);
        }

        return $total_bytes;
    }

    private function getAllPaths($path)
    {
        $exploded = explode('/', $path);
        $paths = [];

        for($i = 0; $i < count($exploded); $i++)
        {
            $url = '';

            for($j = 0; $j <= $i; $j++)
            {
                $url.=$exploded[$j] . '/';
            }

            $paths[] = [
                'name' => $exploded[$i],
                'path' => trim($url, '/')
            ];
        }

        return $paths;
    }

    private function isDirectory($path, $name)
    {
        return Storage::getMetadata($path.'/'.$name)['type'] === 'dir';
    }

    private function getDirectoriesList(){
        $directories = Storage::allDirectories($this->base_path);
        $final = [
            ['path' => 'public', 'name' => 'home']
        ];

        foreach($directories as $directory)
        {
            $exploded = explode('/', $directory);
            $name = '';

            for($i = 1; $i < count($exploded); $i++)
            {
                if($i == count($exploded) -1)
                {
                    $name .= "&nbsp;&nbsp;".$exploded[$i];
                } else {
                    $name .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }

            $final[] = [
                'path' => $directory,
                'name' => $name
            ];
        }

        return $final;
    }

    /**------------------------------
     * File Functions
     * ------------------------------
     * ->getClientOriginalName()
     * ->getClientOriginalExtension()
     * ->getRealPath()
     * ->getSize();
     * ->getMimeType()
     * ------------------------------
     */
}