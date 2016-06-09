@extends('dashboard.layouts.app')

@section('content')

    <section class="content-header">
        <h1>Edit Speaker</h1>
        @include('dashboard._breadcrumbs')
    </section>

    <section class="content">
        <div class="row">
        	<div class="col-md-4">
	        	@include('dashboard.speakers.forms._edit')
        	</div>

			<div class="col-md-8">
				@include('dashboard.speakers._all')
			</div>
        </div>
    </section>

@endsection
