@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.user.title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userIndex') }}">@lang('cruds.user.title')</a></li>
                        <li class="breadcrumb-item active">@lang('global.edit')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('global.edit')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('userUpdate',$user->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>@lang('cruds.user.fields.name')</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('name',$user->name) }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('cruds.user.fields.email')</label>
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? "is-invalid":"" }}" value="{{ old('email',$user->email) }}" required>
                                @if($errors->has('email'))
                                    <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            @canany(['roles.edit','user.edit'])
                            <div class="form-group">
                                <label>@lang('cruds.role.fields.roles')</label>
                                <select class="select2" multiple="multiple" name="roles[]" data-placeholder="@lang('pleaseSelect')" style="width: 100%;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ ($user->hasRole($role->name) ? "selected":'') }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endcan
                            <label>@lang('cruds.user.fields.password')</label>
                            <div class="form-group">
                                <input type="password" name="password" id="password-field" class="form-control {{ $errors->has('password') ? "is-invalid":"" }}">
                                <span toggle="#password-field" class="fa fa-fw fa-eye toggle-password field-icon"></span>
                                @if($errors->has('password'))
                                    <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('global.login_password_confirmation')</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                <span toggle="#password-confirm" class="fa fa-fw fa-eye toggle-password field-icon"></span>
                                @if($errors->has('password_confirmation'))
                                    <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('userIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
