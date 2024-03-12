@extends('layouts.app')

@section('title', 'Programme')
@section('content')
        {{ $programme }}

    <section class="content">

        <div id="pspdfkit" style="height: 100vh"></div>


    </section>


		<script src="assets/pspdfkit.js"></script>

		<script>
			PSPDFKit.load({
				container: "#pspdfkit",
				document: "document.pdf", // Add the path to your document here.
			})
			.then(function(instance) {
				console.log("PSPDFKit loaded", instance);
			})
			.catch(function(error) {
				console.error(error.message);
			});
		</script>
@stop
