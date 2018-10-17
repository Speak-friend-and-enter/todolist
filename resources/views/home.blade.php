@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload user logo</div>

                <div class="card-body">
                    <form action="/user/upload-logo" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <br />
                        <input type="file" name="logo" accept="image/*"/>
                        <br /><br />
                        <input type="submit" value="Save" />
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
