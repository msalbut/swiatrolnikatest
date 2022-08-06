<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use App\Models\Category;
use App\Models\Blocked;
use App\Models\Image as ContentImage;
use App\Models\ImageNew;
use App\Classes\Helper;
// use File;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $title = "Artykuły";
        $users = User::latest()->get();
        $where = [];
        $whereState = [1, 0];
        if ($request->title) {
            $where[] = ['title', 'LIKE', "%" . ($request->title) . "%"];
        }
        if ($request->category) {
            $where[] = ['catid', $request->category];
        }
        if ($request->author) {
            $where[] = ['created_by', $request->author];
        }

        if ($request->has('state') && $request->input('state') != null) {
            $whereState = [Content::ARTICLE_STATES[$request->state]];
        }
        if ($request->catid) {
            $where[] = ['catid', $request->catid];
        }
        if ($request->sort == "hitsUp") {
            $sortColumn = 'hits';
            $sortDirection = 'asc';
        } elseif ($request->sort == "hitsDown") {
            $sortColumn = 'hits';
            $sortDirection = 'desc';
        } elseif ($request->sort == "publishUp") {
            $sortColumn = 'publish_up';
            $sortDirection = 'asc';
        } elseif ($request->sort == "publishDown") {
            $sortColumn = 'publish_up';
            $sortDirection = 'desc';
        } else {
            $sortColumn = 'created_at';
            $sortDirection = 'desc';
        }

        $content = Content::whereIn('state', $whereState)->where($where)->orderBy($sortColumn, $sortDirection)->with('blocked')->paginate(50)->withQueryString();
        $categories = Category::get();

        return view('admin.article.article', compact('content', 'title', 'users', 'categories'));
    }
    public function create()
    {
        $title = "Tworzenie nowego Artykułu";
        $categories = Category::where('published', 1)->where('level', '>', 0)->where('parent_id', '>', 0)->get();
        $cat = $categories->groupBy('level');
        $main_category = $cat[1]->sortBy('position');
        $secoundary_category = $cat[2]->groupBy('parent_id');
        $authors = User::get();
        return view('admin.article.create', compact('title', 'main_category', 'secoundary_category', 'authors'));
    }
    public function store(Request $request)
    {
        $originalWidth = 1280;
        $originalHight = 720;
        $mainWidth = 800;
        $mainHeight = 450;

        $thumbWidth = 320;
        $thumbHeight = 180;

        $form = $request->all();

        if ($form['btn'] != 'zamknij') {
            if ($request->image_not_required == "0") {
                $request->validate([
                    'title' => 'required|unique:content|max:255',
                    'fulltext' => 'required',
                    'image_intro' => 'required',
                    'image_intro_alt' => 'required',
                ]);
            } else {
                $request->validate([
                    'title' => 'required|unique:content|max:255',
                    'fulltext' => 'required',
                ]);
            }
        }
        if (!array_key_exists('has_position', $form)) {
            $form['has_position'] = 'no';
            $form['position'] = 0;
        } else {
            Content::where('has_position', 'yes')->where('position', $form['position'])->update(['has_position' => 'no']);
            // dd($staryart);
        }
        if (is_null($form['publish_up'])) {
            $form['publish_up'] = date('Y-m-d\TH:i');
        }
        $form['alias'] = \Str::slug($request->input('title'));
        $form['version'] = 1;
        $form['pilne'] = $request->pilne;
        if (is_null($form['link'])) {
            $form['link'] = false;
        }
        if (is_null($form['zrodlo'])) {
            $form['zrodlo'] = "";
        }
        $form['urls'] = '{"urla":"' . $form['link'] . '","urlatext":"' . $form['zrodlo'] . '","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}';

        $imagename = str_replace(config('app.url') . '/', '', $form['image_intro']);
        $imagename = str_replace('//', '/', $imagename);

        switch ($form['btn']) {
            case 'zapisz':
                $content = Content::create($form);
                if ($request->image_not_required == "0") {

                    if (getimagesize($imagename)[0] != 1280 and getimagesize($imagename)[1] != 720) {
                        return redirect()->back()->withErrors(['msg' => 'Zdjęcie musi mieć wymiary 1280x720']);
                    };

                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'desktop',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'tablet',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'smartphone',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);

                    //Nowe idzie
                    $main_grafika = str_replace(" ", "_", $imagename);
                    $main_grafika = str_replace("%20", "_", $main_grafika);
                    $main_grafika = str_replace("%C3%B3", "o", $main_grafika);
                    $main_grafika = str_replace("ą", "a", $main_grafika);
                    $main_grafika = str_replace("ć", "c", $main_grafika);
                    $main_grafika = str_replace("ę", "e", $main_grafika);
                    $main_grafika = str_replace("ł", "l", $main_grafika);
                    $main_grafika = str_replace("ń", "n", $main_grafika);
                    $main_grafika = str_replace("ó", "o", $main_grafika);
                    $main_grafika = str_replace("ś", "s", $main_grafika);
                    $main_grafika = str_replace("ź", "z", $main_grafika);
                    $main_grafika = str_replace("ż", "z", $main_grafika);
                    $main_grafika = str_replace("images", "images_new/main", $main_grafika);
                    $originalImagePath = str_replace('images_new/main', 'images_new/original', $main_grafika);

                    $oldPath = str_replace("%20", " ", $imagename);
                    $oldPath = str_replace("%C3%B3", "ó", $oldPath);

                    $mainname = $main_grafika;
                    $path = explode("/", $main_grafika);
                    $path_for_miniaturki = 'storage/images_new/thumbs/m_' . end($path);
                    $path_for_main = 'storage/images_new/main/' . end($path);
                    $new_path = '';

                    $pathOrg = explode("/", $originalImagePath);
                    $pathOrgCount = count($path);
                    for ($i = 0; $i < $pathOrgCount - 1; $i++) {
                        $new_path .= $pathOrg[$i] . '/';
                    }
                    $ile = ImageNew::where('content_id', $content->id)->count();
                    if ($ile < 3 and (File::exists($oldPath) or File::exists($imagename))) {

                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);

                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    } else {
                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);
                        ImageNew::where('content_id', $content->id)->where('type', 'original')->update([
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'main')->update([
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'thumbnail')->update([
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    }
                }
                // dd($content->image);
                $content->categories()->detach();
                if ($request->category_content) {
                    foreach ($request->category_content as $category_content) {
                        $content->categories()->attach([
                            'category_id' => $category_content,
                        ]);
                    }
                }

                return redirect()->back()->with(['message' => 'Artykuł został utworzony.', 'type' => 'success']);
                break;
            case 'zapisz-i-zamknij':
                $content = Content::create($form);
                if ($request->image_not_required == "0") {
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'desktop',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'tablet',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'smartphone',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);

                    $main_grafika = str_replace(" ", "_", $imagename);
                    $main_grafika = str_replace("%20", "_", $main_grafika);
                    $main_grafika = str_replace("%C3%B3", "o", $main_grafika);
                    $main_grafika = str_replace("ą", "a", $main_grafika);
                    $main_grafika = str_replace("ć", "c", $main_grafika);
                    $main_grafika = str_replace("ę", "e", $main_grafika);
                    $main_grafika = str_replace("ł", "l", $main_grafika);
                    $main_grafika = str_replace("ń", "n", $main_grafika);
                    $main_grafika = str_replace("ó", "o", $main_grafika);
                    $main_grafika = str_replace("ś", "s", $main_grafika);
                    $main_grafika = str_replace("ź", "z", $main_grafika);
                    $main_grafika = str_replace("ż", "z", $main_grafika);
                    $main_grafika = str_replace("images", "images_new/main", $main_grafika);
                    $originalImagePath = str_replace('images_new/main', 'images_new/original', $main_grafika);

                    $oldPath = str_replace("%20", " ", $imagename);
                    $oldPath = str_replace("%C3%B3", "ó", $oldPath);

                    $mainname = $main_grafika;
                    $path = explode("/", $main_grafika);
                    $path_for_miniaturki = 'storage/images_new/thumbs/m_' . end($path);
                    $path_for_main = 'storage/images_new/main/' . end($path);
                    $new_path = '';

                    $pathOrg = explode("/", $originalImagePath);
                    $pathOrgCount = count($path);
                    for ($i = 0; $i < $pathOrgCount - 1; $i++) {
                        $new_path .= $pathOrg[$i] . '/';
                    }
                    $ile = ImageNew::where('content_id', $content->id)->count();
                    if ($ile < 3 and (File::exists($oldPath) or File::exists($imagename))) {

                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);

                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    } else {
                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);
                        ImageNew::where('content_id', $content->id)->where('type', 'original')->update([
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'main')->update([
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'thumbnail')->update([
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    }
                }
                $content->categories()->detach();
                if ($request->category_content) {
                    foreach ($request->category_content as $category_content) {
                        $content->categories()->attach([
                            'category_id' => $category_content,
                        ]);
                    }
                }
                return redirect(route('administrator.article.index'))->with(['message' => 'Artykuł został utworzony.', 'type' => 'success']);
                break;
            case 'zamknij':
                return redirect(route('administrator.article.index'))->with(['message' => 'Artykuł nie został utworzony.', 'type' => 'danger']);
                break;
        }
    }
    public function show($id)
    {
        $content = Content::with('User')->where('id', $id)->first();
        return view('admin.article.show', compact('content'));
    }
    public function edit($id)
    {

        $title = "Edycja";
        $categories = Category::where('published', 1)->where('level', '>', 0)->where('parent_id', '>', 0)->get();
        $cat = $categories->groupBy('level');
        $content = Content::with('User')->with('blocked')->findOrFail($id);
        $blocklist = Blocked::where('content_id', $content->id)->where('state', 1)->first();
        // dd($content);
        if ($blocklist) {

            if ($blocklist->user_id == Auth::user()->id) {
                $main_category = $cat[1]->sortBy('position');
                $secoundary_category = $cat[2]->groupBy('parent_id');
                $authors = User::get();
                return view('admin.article.edit', compact('content', 'title', 'authors', 'main_category', 'secoundary_category'));
            }
            return redirect()->back()->with(['message' => 'Artykuł zablokowany przez ' . $blocklist->user->name, 'type' => 'success']);
        }
        $block = new Blocked;
        $block->user_id = Auth::user()->id;
        $block->content_id = $content->id;
        $block->state = 1;
        $block->save();
        $main_category = $cat[1]->sortBy('position');
        $secoundary_category = $cat[2]->groupBy('parent_id');
        $authors = User::get();

        return view('admin.article.edit', compact('content', 'title', 'authors', 'main_category', 'secoundary_category'));
    }
    public function update(Request $request, $id)
    {
        $originalWidth = 1280;
        $originalHight = 720;

        $mainWidth = 800;
        $mainHeight = 450;

        $thumbWidth = 320;
        $thumbHeight = 180;

        $form = $request->all();
        if ($form['btn'] != 'zamknij') {
            if ($request->image_not_required == "0") {
                $request->validate([
                    'title' => 'required|max:255',
                    'fulltext' => 'required',
                    'image_intro' => 'required',
                    'image_intro_alt' => 'required',
                ]);
            } else {
                $request->validate([
                    'title' => 'required|max:255',
                    'fulltext' => 'required',
                ]);
            }
        }
        $content = Content::with('User')->findOrFail($id);
        $blocklist = Blocked::where('content_id', $content->id)->where('state', 1)->with('user')->first();
        if (!array_key_exists('has_position', $form)) {
            $form['has_position'] = 'no';
            $form['position'] = 0;
        } else {
            Content::where('has_position', 'yes')->where('position', $form['position'])->whereNotIn('id', [$id])->update(['has_position' => 'no']);
        }
        $form['urls'] = '{"urla":"' . $form['link'] . '","urlatext":"' . $form['zrodlo'] . '","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}';
        $imagename = str_replace(config('app.url') . '/', '', $form['image_intro']);
        $imagename = str_replace('//', '/', $imagename);
        // $form['images'] = '{"image_intro":"' . $imagename . '","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}';
        $form['alias'] = \Str::slug($request->input('alias'));
        switch ($form['btn']) {
            case 'zapisz':
                $content->fill($form);
                Helper::makerevision($content);
                $content->save();
                if ($request->image_not_required == "0") {

                    if(getimagesize($imagename)[0] != 1280 AND getimagesize($imagename)[1] != 720){
                        return redirect()->back()->withErrors(['msg' => 'Zdjęcie musi mieć wymiary 1280x720']);
                    };

                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'desktop',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'tablet',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'smartphone',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    $main_grafika = str_replace(" ", "_", $imagename);
                    $main_grafika = str_replace("%20", "_", $main_grafika);
                    $main_grafika = str_replace("%C3%B3", "o", $main_grafika);
                    $main_grafika = str_replace("ą", "a", $main_grafika);
                    $main_grafika = str_replace("ć", "c", $main_grafika);
                    $main_grafika = str_replace("ę", "e", $main_grafika);
                    $main_grafika = str_replace("ł", "l", $main_grafika);
                    $main_grafika = str_replace("ń", "n", $main_grafika);
                    $main_grafika = str_replace("ó", "o", $main_grafika);
                    $main_grafika = str_replace("ś", "s", $main_grafika);
                    $main_grafika = str_replace("ź", "z", $main_grafika);
                    $main_grafika = str_replace("ż", "z", $main_grafika);
                    $main_grafika = str_replace("images", "images_new/main", $main_grafika);
                    $originalImagePath = str_replace('images_new/main', 'images_new/original', $main_grafika);

                    $oldPath = str_replace("%20", " ", $imagename);
                    $oldPath = str_replace("%C3%B3", "ó", $oldPath);

                    $mainname = $main_grafika;
                    $path = explode("/", $main_grafika);
                    $path_for_miniaturki = 'storage/images_new/thumbs/m_' . end($path);
                    $path_for_main = 'storage/images_new/main/' . end($path);
                    $new_path = '';

                    $pathOrg = explode("/", $originalImagePath);
                    $pathOrgCount = count($path);
                    for ($i = 0; $i < $pathOrgCount - 1; $i++) {
                        $new_path .= $pathOrg[$i] . '/';
                    }
                    $ile = ImageNew::where('content_id', $content->id)->count();

                    if ($ile < 3 and (File::exists($oldPath) or File::exists($imagename))) {

                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);

                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    } else {
                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);
                        ImageNew::where('content_id', $content->id)->where('type', 'original')->update([
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'main')->update([
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'thumbnail')->update([
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    }
                }
                $content->categories()->detach();
                if ($request->category_content) {
                    foreach ($request->category_content as $category_content) {
                        $content->categories()->attach([
                            'category_id' => $category_content,
                        ]);
                    }
                }
                $blocklist->state = 0;
                $blocklist->save();
                return redirect()->back()->with(['message' => 'Artykuł został zapisany.', 'type' => 'success']);
                break;
            case 'zapisz-i-zamknij':
                $content->fill($form);
                Helper::makerevision($content);
                $content->save();
                if ($request->image_not_required == "0") {
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'desktop',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'tablet',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);
                    ContentImage::create([
                        'content_id' => $content->id,
                        'type' => 'smartphone',
                        'path' => $imagename,
                        'alt' => $form['image_intro_alt'],
                    ]);

                    $main_grafika = str_replace(" ", "_", $imagename);
                    $main_grafika = str_replace("%20", "_", $main_grafika);
                    $main_grafika = str_replace("%C3%B3", "o", $main_grafika);
                    $main_grafika = str_replace("ą", "a", $main_grafika);
                    $main_grafika = str_replace("ć", "c", $main_grafika);
                    $main_grafika = str_replace("ę", "e", $main_grafika);
                    $main_grafika = str_replace("ł", "l", $main_grafika);
                    $main_grafika = str_replace("ń", "n", $main_grafika);
                    $main_grafika = str_replace("ó", "o", $main_grafika);
                    $main_grafika = str_replace("ś", "s", $main_grafika);
                    $main_grafika = str_replace("ź", "z", $main_grafika);
                    $main_grafika = str_replace("ż", "z", $main_grafika);
                    $main_grafika = str_replace("images", "images_new/main", $main_grafika);
                    $originalImagePath = str_replace('images_new/main', 'images_new/original', $main_grafika);

                    $oldPath = str_replace("%20", " ", $imagename);
                    $oldPath = str_replace("%C3%B3", "ó", $oldPath);

                    $mainname = $main_grafika;
                    $path = explode("/", $main_grafika);
                    $path_for_miniaturki = 'storage/images_new/thumbs/m_' . end($path);
                    $path_for_main = 'storage/images_new/main/' . end($path);
                    $new_path = '';

                    $pathOrg = explode("/", $originalImagePath);
                    $pathOrgCount = count($path);
                    for ($i = 0; $i < $pathOrgCount - 1; $i++) {
                        $new_path .= $pathOrg[$i] . '/';
                    }
                    $ile = ImageNew::where('content_id', $content->id)->count();
                    if ($ile < 3 and (File::exists($oldPath) or File::exists($imagename))) {

                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);

                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::create([
                            'content_id' => $content->id,
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    } else {
                        if (!File::exists($new_path)) {
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $originalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($originalImagePath);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($originalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $originalImagePath);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($originalImagePath)->encode('webp')->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($originalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($originalImagePath)->encode('webp')->save($webp_thumb_path);
                        ImageNew::where('content_id', $content->id)->where('type', 'original')->update([
                            'type' => 'original',
                            'path' => $originalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'main')->update([
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $form['image_intro_alt'],
                        ]);
                        ImageNew::where('content_id', $content->id)->where('type', 'thumbnail')->update([
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $form['image_intro_alt'],
                        ]);
                    }
                }
                $content->categories()->detach();
                if ($request->category_content) {
                    foreach ($request->category_content as $category_content) {
                        $content->categories()->attach([
                            'category_id' => $category_content,
                        ]);
                    }
                }
                $blocklist->state = 0;
                $blocklist->save();
                return redirect(route('administrator.article.index'))->with(['message' => 'Artykuł został zapisany.', 'type' => 'success']);
                break;
            case 'zamknij':
                $blocklist->state = 0;
                $blocklist->save();
                return redirect(route('administrator.article.index'))->with(['message' => 'Artykuł nie został zapisany.', 'type' => 'danger']);
                break;
        }
        return redirect()->back();
    }

    public function unlock($id)
    {
        $block = Blocked::where('id', $id)->first();
        $block->state = 0;
        $block->save();
        return redirect()->back()->with(['message' => 'Artykuł odblokowany', 'type' => 'success']);
    }
    public function change(Request $request, $id)
    {
        $article = Content::findOrFail($id);
        if ($request->has('action')) {
            $action = $request->get('action');
            switch ($action) {
                case 'featured':
                    $article->fill(['featured' => 1]);
                    Helper::makerevision($article);
                    $article->save();
                    return redirect()->back();
                    break;
                case 'unfeatured':
                    $article->fill(['featured' => 0]);
                    Helper::makerevision($article);
                    $article->save();
                    return redirect()->back();
                    break;
                case 'unpublish':
                    $article->fill(['state' => 0]);
                    Helper::makerevision($article);
                    $article->save();
                    return redirect()->back();
                    break;
                case 'publish':
                    $article->fill(['state' => 1]);
                    Helper::makerevision($article);
                    $article->save();
                    return redirect()->back();
                    break;
                case 'archive':
                    $article->fill(['state' => 2]);
                    Helper::makerevision($article);
                    $article->save();
                    return redirect()->back();
                    break;
                case 'delete':
                    $article->fill(['state' => -2]);
                    Helper::makerevision($article);
                    $article->save();
                    return redirect()->back();
                    break;
                default:
                    return redirect()->back();
            }
        }
    }

}
