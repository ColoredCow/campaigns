@if (session('success'))
    <div class="alert alert-success">
        <i data-feather="check-square" class="icon-20 mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true"><i data-feather="x" class="icon-15"></i></span>
	    </button>
	</div>
@elseif (session('failed'))
    <div class="alert alert-danger">
        <i data-feather="x-square" class="icon-20 mr-2"></i>{{ session('failed') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true"><i data-feather="x" class="icon-15"></i></span>
	    </button>
	</div>
@elseif (session('warning'))
    <div class="alert alert-warning">
        <i data-feather="alert-triangle" class="icon-20 mr-2"></i>{{ session('warning') }}
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true"><i data-feather="x" class="icon-15"></i></span>
	    </button>
	</div>
@endif
