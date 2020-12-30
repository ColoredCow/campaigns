@if (session('success'))
    <div class="alert alert-success">
        <i data-feather="check-square" class="w-20 h-20 mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true"><i data-feather="x" class="w-15 h-15"></i></span>
	    </button>
	</div>
@elseif (session('failed'))
    <div class="alert alert-danger">
        <i data-feather="x-square" class="w-20 h-20 mr-2"></i>{{ session('failed') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true"><i data-feather="x" class="w-15 h-15"></i></span>
	    </button>
	</div>
@elseif (session('warning'))
    <div class="alert alert-warning">
        <i data-feather="alert-triangle" class="w-20 h-20 mr-2"></i>{{ session('warning') }}
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true"><i data-feather="x" class="w-15 h-15"></i></span>
	    </button>
	</div>
@endif
