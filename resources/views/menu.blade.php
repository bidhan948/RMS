@extends('layouts.master')
@section('title', 'MENU')
@section('main_content')
@section('is_active', 'active')
<h6 class="mb-2">Menus list</h6>
<div class="row" style="text-align:right;">
    <div class="col-12">
        <a class="btn btn-sm btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class="fa-solid fa-plus px-1"></i> Add Menu</a>
    </div>
</div>

<!--This is Modal for adding menu-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('menu.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="form-control-label">Name <span
                                    class="text-danger font-weight-bold">*</span></label>
                            <input name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image" class="form-control-label">Image </label>
                            <input name="image" class="form-control @error('image') is-invalid @enderror"
                                type="file">
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                        <div class="form-group">
                            <label for="name" class="form-control-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" required></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end of Modal for adding menu-->

<div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">S.No</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Name
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $key => $menu)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $menu->name }}</td>
                    <td class="text-center">{{ $menu->description }}</td>
                    <td class="text-center">
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal{{ $key }}"
                            class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square px-1"></i>Edit</a>

                        <!--This is Modal for editing menu-->
                        <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('menu.update', $menu) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-control-label">Name <span
                                                            class="text-danger font-weight-bold">*</span></label>
                                                    <input name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        type="text" value="{{ $menu->name }}" required>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="image" class="form-control-label">Image </label>
                                                    <input name="image"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        type="file">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="image" class="form-control-label">Old Image
                                                        preview</label>
                                                    <img src="{{ asset('storage/thumbnails/' . $menu->image) }}"
                                                        width="50" height="50">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-control-label">Description</label>
                                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" required>{{ $menu->description }}</textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end of Modal for editing menu-->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('scripts')
<script>
    $(function() {
        if ({{ $errors->any() }}) {
            $("#exampleModal").show();
        }
    });
</script>
@endsection
