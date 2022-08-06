<?php

namespace App\Http\Controllers\FileManager;

use Illuminate\Support\Facades\Storage;
use App\Events\FileIsMoving;
use App\Events\FileWasMoving;
use App\Events\FolderIsMoving;
use App\Events\FolderWasMoving;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ItemsController extends LfmController
{
    /**
     * Get the images to load for a selected folder.
     *
     * @return mixed
     */
    public function getItems()
    {
        $currentPage = self::getCurrentPageFromRequest();
        $perPage = $this->helper->getPaginationPerPage();
        $items = array_merge($this->lfm->folders(), $this->lfm->files());

        // if ($pattern) {
        //     $dir_iterator = new \RecursiveDirectoryIterator("storage/images/");
        //     $it = new \RecursiveIteratorIterator($dir_iterator);
        //     $it = new \RegexIterator($it, '/^storage(\/|\\\)images(\/|\\\)(^thumbs)*'. $pattern.'(.*)/i');
        //     $filesArray = [];
        //     $it->rewind();
        //     while ($it->valid()) {
        //         if (!$it->isDot()) {
        //             if (!str_contains($it->getSubPath(), 'thumbs')) {
        //                 $filesArray[] = $it->key();
        //             }
        //         }
        //         $it->next();
        //     }
        //     $files = array_map(function ($file_path) {
        //         return $this->pretty($file_path);
        //     }, $filesArray);
        //     return $this->sortByColumn($files);
        // }

        return [
            'items' => array_map(function ($item) {
                return $item->fill()->attributes;
            }, array_slice($items, ($currentPage - 1) * $perPage, $perPage)),
            'paginator' => [
                'current_page' => $currentPage,
                'total' => count($items),
                'per_page' => $perPage,
            ],
            'display' => $this->helper->getDisplayMode(),
            'working_dir' => $this->lfm->path('working_dir'),
        ];
    }

    public function move()
    {
        $items = request('items');
        $folder_types = array_filter(['user', 'share'], function ($type) {
            return $this->helper->allowFolderType($type);
        });
        return view('laravel-filemanager.move')
            ->with([
                'root_folders' => array_map(function ($type) use ($folder_types) {
                    $path = $this->lfm->dir($this->helper->getRootFolder($type));

                    return (object) [
                        'name' => trans('laravel-filemanager::lfm.title-' . $type),
                        'url' => $path->path('working_dir'),
                        'children' => $path->folders(),
                        'has_next' => !($type == end($folder_types)),
                    ];
                }, $folder_types),
            ])
            ->with('items', $items);
    }

    public function domove()
    {
        dd($this->helper->items);
        $target = $this->helper->input('goToFolder');
        $items = $this->helper->input('items');

        foreach ($items as $item) {
            $old_file = $this->lfm->pretty($item);
            $is_directory = $old_file->isDirectory();

            $file = $this->lfm->setName($item);

            if (!Storage::disk($this->helper->config('disk'))->exists($file->path('storage'))) {
                abort(404);
            }

            $old_path = $old_file->path();

            if ($old_file->hasThumb()) {
                $new_file = $this->lfm->setName($item)->thumb()->dir($target);
                if ($is_directory) {
                    event(new FolderIsMoving($old_file->path(), $new_file->path()));
                } else {
                    event(new FileIsMoving($old_file->path(), $new_file->path()));
                }
                $this->lfm->setName($item)->thumb()->move($new_file);
            }
            $new_file = $this->lfm->setName($item)->dir($target);
            $this->lfm->setName($item)->move($new_file);
            if ($is_directory) {
                event(new FolderWasMoving($old_path, $new_file->path()));
            } else {
                event(new FileWasMoving($old_path, $new_file->path()));
            }
        };

        return parent::$success_response;
    }

    private static function getCurrentPageFromRequest()
    {
        $currentPage = (int) request()->get('page', 1);
        $currentPage = $currentPage < 1 ? 1 : $currentPage;

        return $currentPage;
    }
}
