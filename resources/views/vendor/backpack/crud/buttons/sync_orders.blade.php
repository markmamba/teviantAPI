{{-- The inactive version of the button --}}
<a id="orders-sync-button-inactive" class="btn btn-primary btn-flat" title="Synch orders" data-toggle="tooltip" style="width: 130px;">
	<i class="fa fa-refresh fa-fw"></i> Sync Orders
</a>
{{-- The active version of the button when clicked --}}
<a id="orders-sync-button-active" class="btn btn-primary btn-flat disabled" title="Synch orders" data-toggle="tooltip" style="display: none; width: 130px;">
	<i class="fa fa-refresh fa-fw fa-spin"></i> Syncing Orders
</a>

@push('after_scripts')
<script>
$(document).ready(function(){
		// console.log('Document loaded');
		
		$("#orders-sync-button-inactive").click(function(){
			$("#orders-sync-button-inactive").hide();
			$("#orders-sync-button-active").show();

			// Assign handlers immediately after making the request,
	        // and remember the jqXHR object for this request
	        var jqxhr = $.ajax({
	            url: "{{ route('orders.sync') }}",
	            method: 'GET'
	        })
	        .done(function(data) {
	        	// console.log("success");
	        	new PNotify({
				  title: "Success!",
				  text: "Orders have been synced. Reloading page...",
				  type: "success"
				});
	        	location.reload();
	        })
	        .fail(function(data) {
	            // console.log("error");
	            new PNotify({
					title: "Failed to Sync",
					text: "Check your network or retry later.",
					type: "warning"
				});
	        })
	        .always(function(data) {
	        	// console.log("always");
	        	$("#orders-sync-button-inactive").show();
				$("#orders-sync-button-active").hide();
	        });
		});
		
});
</script>
@endpush