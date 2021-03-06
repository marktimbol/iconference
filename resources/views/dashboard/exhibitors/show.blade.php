@extends('dashboard.layouts.app')

@section('content')
    <section class="content-header">
        <h1>{{ $exhibitor->name }}</h1>
        @include('dashboard._breadcrumbs')
    </section>

    <section class="content">
        <div class="row">
			<div class="col-md-4">
				@include('dashboard.exhibitors.forms._create')
			</div>
			<div class="col-md-8">
				<div class="box box-primary">
					<div class="box-body">
						<ul class="list-group">
							<li class="list-group-item">
								<strong>Name: {{ $exhibitor->name }}</strong></li>
							</li>
							<li class="list-group-item">
								<strong>Stand Number:</strong> {{ $exhibitor->standNumber }}
							</li>
						</ul>	

						<h3>About</h3>
						{!! $exhibitor->about !!}

						<div id="ExhibitorContacts"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('footer_scripts')
	<script src="{{ elixir('js/typeahead.js') }}"></script>
    <script src="/js/ExhibitorContacts.js"></script>
@endsection     