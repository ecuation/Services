@if(session()->has('flash_message'))
	<script type="text/javascript" src="{{ asset('js/libs.js') }}"></script>
	<script type="text/javascript">
	    swal({   
	        title: "{!! session('flash_message.title') !!}",
	        text: "{!! session('flash_message.message') !!}",
	        type: "{!! session('flash_message.notice') !!}",
	        timer: 4000,
	        showConfirmButton: false
	    });
	</script>
@endif