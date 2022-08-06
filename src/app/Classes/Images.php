<?php

namespace App\Classes;

// use File;
// use Intervention\Image\ImageManagerStatic as ImageManager;
// use App\Models\ImageNew;
use Jenssegers\Agent\Agent;
// use Illuminate\Support\Facades\File;

class Images
{
    // public static function createOrginalImage($path, $alt, $id){
    //     $mainWidth = 1280;
    //     $mainHeight = 720;

    //     $new_path = str_replace(" ", "_", $path);
    //     $new_path = str_replace("%20", "_", $new_path);
    //     $new_path = str_replace("%C3%B3", "o", $new_path);
    //     $new_path = str_replace("ą", "a", $new_path);
    //     $new_path = str_replace("ć", "c", $new_path);
    //     $new_path = str_replace("ę", "e", $new_path);
    //     $new_path = str_replace("ł", "l", $new_path);
    //     $new_path = str_replace("ń", "n", $new_path);
    //     $new_path = str_replace("ó", "o", $new_path);
    //     $new_path = str_replace("ś", "s", $new_path);
    //     $new_path = str_replace("ź", "z", $new_path);
    //     $new_path = str_replace("ż", "z", $new_path);
    //     $new_path = str_replace("images", "images_new/main", $new_path);


    //     $oldPath = str_replace("%20", " ", $path);
    //     $oldPath = str_replace("%C3%B3", "ó", $oldPath);

    //     $mainname = $new_path;
    //     $path = explode("/", $new_path);
    //     $path1 = count($path);

    //     $new_path = '';

    //     for ($i = 0; $i < $path1 - 1; $i++) {
    //         $new_path .= $path[$i] . '/';
    //     }
    //     $ile = ImageNew::where('type', 'main')->where('content_id', $id)->count();
    //     // dd();
    //     if (File::exists($oldPath) or File::exists($path)) {

    //         if (!File::exists($new_path)) {
    //             File::makeDirectory($new_path, 0777, true, true);
    //         }
    //         File::copy($oldPath, $mainname);

    //         $image_resize = ImageManager::make($mainname);
    //         $image_resize->resize($mainWidth, $mainHeight);
    //         $image_resize->save($mainname);

    //         if ($ile == 0) {
    //             ImageNew::create([
    //                 'content_id' => $id,
    //                 'type' => 'main',
    //                 'path' => $mainname,
    //                 'alt' => $alt,
    //             ]);
    //         }else{
    //             ImageNew::where('type', 'original')->where('content_id', $id)->update([
    //                 'path' => $mainname,
    //                 'alt' => $alt,
    //             ]);
    //         }
    //     }
    // }
    // public static function createMainImage($path, $alt, $id)
    // {
    //     $thumbWidth = 800;
    //     $thumbHeight = 450;

    //     $new_path = str_replace(" ", "_", $path);
    //     $new_path = str_replace("%20", "_", $new_path);
    //     $new_path = str_replace("%C3%B3", "o", $new_path);
    //     $new_path = str_replace("ą", "a", $new_path);
    //     $new_path = str_replace("ć", "c", $new_path);
    //     $new_path = str_replace("ę", "e", $new_path);
    //     $new_path = str_replace("ł", "l", $new_path);
    //     $new_path = str_replace("ń", "n", $new_path);
    //     $new_path = str_replace("ó", "o", $new_path);
    //     $new_path = str_replace("ś", "s", $new_path);
    //     $new_path = str_replace("ź", "z", $new_path);
    //     $new_path = str_replace("ż", "z", $new_path);


    //     $oldPath = str_replace("%20", " ", $path);
    //     $oldPath = str_replace("%C3%B3", "ó", $oldPath);

    //     $mainname = $new_path;
    //     $path = explode("/", $new_path);
    //     $path1 = count($path);

    //     $path_for_miniaturki = 'storage/miniaturki/thumbs/m_' . end($path);
    //     $new_path = '';

    //     for ($i = 0; $i < $path1 - 1; $i++) {
    //         $new_path .= $path[$i] . '/';
    //     }
    //     $ile = ImageNew::where('type', 'thumbnail')->where('content_id', $id)->count();
    //     if (File::exists($oldPath) or File::exists($path)) {

    //         if (!File::exists($new_path)) {
    //             File::makeDirectory($new_path, 0777, true, true);
    //         }
    //         File::copy($oldPath, $mainname);

    //         $image_resize = ImageManager::make($mainname);
    //         $image_resize->resize($thumbWidth, $thumbHeight);
    //         $image_resize->save($path_for_miniaturki);
    //         if ($ile == 0) {
    //             ImageNew::create([
    //                 'content_id' => $id,
    //                 'type' => 'thumbnail',
    //                 'path' => $path_for_miniaturki,
    //                 'alt' => $alt,
    //             ]);
    //         } else {
    //             ImageNew::where('type', 'main')->where('content_id', $id)->update([
    //                 'path' => $path_for_miniaturki,
    //                 'alt' => $alt,
    //             ]);
    //         }

    //     }
    // }
    // public static function createThumbnail($path, $alt, $id)
    // {
    //     $thumbWidth = 320;
    //     $thumbHeight = 180;

    //     $new_path = str_replace(" ", "_", $path);
    //     $new_path = str_replace("%20", "_", $new_path);
    //     $new_path = str_replace("%C3%B3", "o", $new_path);
    //     $new_path = str_replace("ą", "a", $new_path);
    //     $new_path = str_replace("ć", "c", $new_path);
    //     $new_path = str_replace("ę", "e", $new_path);
    //     $new_path = str_replace("ł", "l", $new_path);
    //     $new_path = str_replace("ń", "n", $new_path);
    //     $new_path = str_replace("ó", "o", $new_path);
    //     $new_path = str_replace("ś", "s", $new_path);
    //     $new_path = str_replace("ź", "z", $new_path);
    //     $new_path = str_replace("ż", "z", $new_path);


    //     $oldPath = str_replace("%20", " ", $path);
    //     $oldPath = str_replace("%C3%B3", "ó", $oldPath);

    //     $mainname = $new_path;
    //     $path = explode("/", $new_path);
    //     $path1 = count($path);

    //     $path_for_miniaturki = 'storage/miniaturki/thumbs/m_' . end($path);
    //     $new_path = '';

    //     for ($i = 0; $i < $path1 - 1; $i++) {
    //         $new_path .= $path[$i] . '/';
    //     }
    //     $ile = ImageNew::where('type', 'thumbnail')->where('content_id', $id)->count();
    //     // dd();
    //     if (File::exists($oldPath) or File::exists($path)) {

    //         if (!File::exists($new_path)) {
    //             File::makeDirectory($new_path, 0777, true, true);
    //         }
    //         File::copy($oldPath, $mainname);

    //         $image_resize = ImageManager::make($mainname);
    //         $image_resize->resize($thumbWidth, $thumbHeight);
    //         $image_resize->save($path_for_miniaturki);
    //         if ($ile == 0) {
    //             ImageNew::create([
    //                 'content_id' => $id,
    //                 'type' => 'thumbnail',
    //                 'path' => $path_for_miniaturki,
    //                 'alt' => $alt,
    //             ]);
    //         } else {
    //             ImageNew::where('type', 'thumbnail')->where('content_id', $id)->update([
    //                 'path' => $path_for_miniaturki,
    //                 'alt' => $alt,
    //             ]);
    //         }

    //     }
    // }



    public static function orginalImagePath($obj, $type = 'jpg')
    {
        // dd($obj->orginalImage);
        if (isset($obj->orginalImage)) {
            // if ($type == 'webp') {
            //     $imagePath = $obj->orginalImage->webp_path;
            // } else {
                $imagePath = $obj->orginalImage->path;
            // }
        } else {
            $imagePath = 'storage/images_new/original/default/Grafika-SR.jpg';
        }
        return $imagePath;
    }
    public static function mainImagePath($obj,  $type = 'jpg')
    {
        if (isset($obj->mainImage)) {
            if ($type == 'webp') {
                $imagePath = $obj->mainImage->webp_path;
            }else{
                $imagePath = $obj->mainImage->path;
            }
        } else {
            $imagePath = 'storage/images_new/main/default/Grafika-SR.jpg';
        }
        return $imagePath;
    }
    public static function thumbnailPath($obj,  $type = 'jpg')
    {
        if (isset($obj->thumbnail)) {
            // if ($type == 'webp') {
                // $imagePath = $obj->thumbnail->webp_path;
            // }else{
                $imagePath = $obj->thumbnail->path;
            // }
        } else {
            $imagePath = 'storage/images_new/thumbs/default/m_Grafika-SR.jpg';
        }
        return $imagePath;
    }

    public static function mainImage($obj, $lazy = false){
        // $agent = new Agent();
        $alt = (isset($obj->mainImage->alt)) ?  $obj->mainImage->alt : 'Brak grafiki';

        if ($lazy == false )
        // && $agent->browser() == 'Safari')
        {
            $html = '<img src="' . asset(Images::mainImagePath($obj)) . '" alt="' . $alt . '" width=800 height=450>';
        // } elseif ($lazy == false && $agent->browser() != 'Safari') {
            // $html = '<img src="' . asset(Images::mainImagePath($obj, 'webp')) . '" alt="' . $alt . '" width=320 height=180>';
        } else {
            $html = '<img class="lazy" src="' . asset('storage/images_new/default/placeholder.gif') . '" data-src="' . asset(Images::mainImagePath($obj)) . '"data-webpsrc="' . asset(Images::mainImagePath($obj, 'webp')) . ' " alt="' . $alt . '" width=320 height=180>';
        }
        // $html = '<img class="lazy" src="'.asset('storage/images_new/default/placeholder.gif').'" data-src="' . asset(Images::mainImagePath($obj)) . '"data-webpsrc="' . asset(Images::mainImagePath($obj, false, 'webp')) . '" alt="'. $alt  . '" width=640 height=320>';
        return $html;
    }

    public static function thumbnail($obj, $lazy = false){
        // $agent = new Agent();
        $alt = (isset($obj->thumbnail->alt)) ?  $obj->thumbnail->alt : 'Brak grafiki';
        if($lazy == false ){
        // && $agent->browser() == 'Safari'){
            $html = '<img src="' . asset(Images::thumbnailPath($obj)) . '" alt="' . $alt. '" width=320 height=180>';
        // } elseif($lazy == false && $agent->browser() != 'Safari'){
            // $html = '<img src="' . asset(Images::thumbnailPath($obj, 'webp')) . '" alt="' . $alt. '" width=320 height=180>';
        }else{
            $html = '<img class="lazy" src="' . asset('storage/images_new/default/placeholder.gif') . '" data-src="' . asset(Images::thumbnailPath($obj)) . '"data-webpsrc="'. asset(Images::thumbnailPath($obj, 'webp')).' " alt="' . $alt. '" width=320 height=180>';
        }
        return $html;
    }

    public static function ampImage($obj)
    {
        $alt = (isset($obj->thumbnail->alt)) ?  $obj->thumbnail->alt : 'Brak grafiki';
        $html = '<amp-img src="'. asset(Images::thumbnailPath($obj)).'" alt="'. $alt .'" width="449" height="241" layout="responsive"></amp-img>';
        return $html;
    }
}
