<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class FileController extends Controller
{
    public function store(Request $request)
    {
        if (request()->file('gallery')) {
            $files = request()->file('gallery');

            for ($i = 0; $i < count($files); $i++) {
                $file = $files[$i];
                $filename = time().'.'.$file->extension();

                if (!file_exists(public_path() . '/uploads/products')) {
                    mkdir(public_path() . '/uploads/products', 0755, true);
                }

                $img = Image::make($file->path());

                $img->resize(2500, 2500, function ($const) {
                    $const->aspectRatio();
                });
                
                if($request->watermark == 'w2')
                {
                    $watermark = Image::make(public_path() . '/img/watermark2.png');
                    $img->insert($watermark, 'center');
                }
                else {
                    $watermark = Image::make(public_path() . '/img/watermark.png');
                    $img->insert($watermark, 'center');
                }

                $img->save(public_path() . '/uploads/products/' . $filename);

                return \Response::make('/uploads/products/' . $filename, 200, [
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if (request()->file('image')) {
            $file = request()->file('image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/')) {
                mkdir(public_path() . '/uploads/', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(700, 700, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/' . $filename);

            return \Response::make('/uploads/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('video')) {
            $file = request()->file('video');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/videos')) {
                mkdir(public_path() . '/uploads/videos', 0755, true);
            }

            $file->move(public_path() . '/uploads/videos', $filename);

            return \Response::make('/uploads/videos/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('firm_gallery')) {
            $files = request()->file('firm_gallery');

            for ($i = 0; $i < count($files); $i++) {
                $file = $files[$i];
                $filename = time().'.'.$file->extension();

                if (!file_exists(public_path() . '/uploads/firms')) {
                    mkdir(public_path() . '/uploads/firms', 0755, true);
                }

                $img = Image::make($file->path());

                $img->resize(2500, 2500, function ($const) {
                    $const->aspectRatio();
                });
                
                if($request->watermark == 'w2')
                {
                    $watermark = Image::make(public_path() . '/img/watermark2.png');
                    $img->insert($watermark, 'center');
                }
                else {
                    $watermark = Image::make(public_path() . '/img/watermark.png');
                    $img->insert($watermark, 'center');
                }

                $img->save(public_path() . '/uploads/firms/' . $filename);

                return \Response::make('/uploads/firms/' . $filename, 200, [
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if (request()->file('firm_videogallery')) {
            $files = request()->file('firm_videogallery');

            for ($i = 0; $i < count($files); $i++) {
                $file = $files[$i];
                $filename = time().'.'.$file->extension();

                if (!file_exists(public_path() . '/uploads/firm-videos')) {
                    mkdir(public_path() . '/uploads/firm-videos', 0755, true);
                }

                $file->move(public_path() . '/uploads/firm-videos', $filename);

                return \Response::make('/uploads/firm-videos/' . $filename, 200, [
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if (request()->file('energoaudit_gallery')) {
            $files = request()->file('energoaudit_gallery');

            for ($i = 0; $i < count($files); $i++) {
                $file = $files[$i];
                $filename = time().'.'.$file->extension();

                if (!file_exists(public_path() . '/uploads/audit')) {
                    mkdir(public_path() . '/uploads/audit', 0755, true);
                }

                $img = Image::make($file->path());

                $img->resize(2500, 2500, function ($const) {
                    $const->aspectRatio();
                });
                
                if($request->watermark == 'w2')
                {
                    $watermark = Image::make(public_path() . '/img/watermark2.png');
                    $img->insert($watermark, 'center');
                }
                else {
                    $watermark = Image::make(public_path() . '/img/watermark.png');
                    $img->insert($watermark, 'center');
                }

                $img->save(public_path() . '/uploads/audit/' . $filename);

                return \Response::make('/uploads/audit/' . $filename, 200, [
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if (request()->file('energoarenda_gallery')) {
            $files = request()->file('energoarenda_gallery');

            for ($i = 0; $i < count($files); $i++) {
                $file = $files[$i];
                $filename = time().'.'.$file->extension();

                if (!file_exists(public_path() . '/uploads/arenda')) {
                    mkdir(public_path() . '/uploads/arenda', 0755, true);
                }

                $img = Image::make($file->path());

                $img->resize(2500, 2500, function ($const) {
                    $const->aspectRatio();
                });
                
                if($request->watermark == 'w2')
                {
                    $watermark = Image::make(public_path() . '/img/watermark2.png');
                    $img->insert($watermark, 'center');
                }
                else {
                    $watermark = Image::make(public_path() . '/img/watermark.png');
                    $img->insert($watermark, 'center');
                }

                $img->save(public_path() . '/uploads/arenda/' . $filename);

                return \Response::make('/uploads/arenda/' . $filename, 200, [
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if (request()->file('energoaudit_icon')) {
            $file = request()->file('energoaudit_icon');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/')) {
                mkdir(public_path() . '/uploads/', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(700, 700, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/' . $filename);

            return \Response::make('/uploads/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('energoarenda_icon')) {
            $file = request()->file('energoarenda_icon');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/')) {
                mkdir(public_path() . '/uploads/', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(700, 700, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/' . $filename);

            return \Response::make('/uploads/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }
    }
}