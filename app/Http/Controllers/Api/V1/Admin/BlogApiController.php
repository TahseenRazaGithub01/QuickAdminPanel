<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Blog;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\Admin\BlogResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('blog_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlogResource(Blog::with(['sites', 'categories', 'tags'])->get());
    }

    public function store(StoreBlogRequest $request)
    {
        $blog = Blog::create($request->all());
        $blog->sites()->sync($request->input('sites', []));
        $blog->categories()->sync($request->input('categories', []));
        $blog->tags()->sync($request->input('tags', []));

        if ($request->input('image', false)) {
            $blog->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($request->input('banner_image', false)) {
            $blog->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->toMediaCollection('banner_image');
        }

        return (new BlogResource($blog))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Blog $blog)
    {
        abort_if(Gate::denies('blog_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlogResource($blog->load(['sites', 'categories', 'tags']));
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update($request->all());
        $blog->sites()->sync($request->input('sites', []));
        $blog->categories()->sync($request->input('categories', []));
        $blog->tags()->sync($request->input('tags', []));

        if ($request->input('image', false)) {
            if (!$blog->image || $request->input('image') !== $blog->image->file_name) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($blog->image) {
            $blog->image->delete();
        }

        if ($request->input('banner_image', false)) {
            if (!$blog->banner_image || $request->input('banner_image') !== $blog->banner_image->file_name) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->toMediaCollection('banner_image');
            }
        } elseif ($blog->banner_image) {
            $blog->banner_image->delete();
        }

        return (new BlogResource($blog))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Blog $blog)
    {
        abort_if(Gate::denies('blog_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blog->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
