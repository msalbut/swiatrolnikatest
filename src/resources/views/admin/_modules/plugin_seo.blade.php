<div class="control-group mb-3 d-flex align-items-center col-12">
    <label for="link" class="col-2 pl-0 mb-0">Meta description</label>
    <input type="text" name="meta" id="jform_metadesc" class="form-control col-10" placeholder="" value="">
</div>
<hr>
<div class="control-group mb-3 d-flex align-items-center col-12">
    <label for="link" class="col-2 pl-0 mb-0">Snippet preview</label>
    <div id="route66-seo-preview"></div>
</div>
<div class="control-group mb-3 d-flex align-items-center col-12">
    <label for="link" class="col-2 pl-0 mb-0">Focus keyword</label>
    <div>
        <input type="text" name="focus_keyword" id="jform_route66seo_keyword" class="input-xxlarge" value="{{ $content->focus_keyword ?? '' }}">
		<button type="button" onclick="analize_start()" style="background-color: #2f6f2f; border: 1px solid rgba(0,0,0,0.2); cursor: default; color: #fff;">Rozpocznij analizę SEO</button>
    </div>
</div>
<div class="control-group mb-3 d-flex align-items-center col-12">
    <label for="link" class="col-2 pl-0 mb-0">Score</label>
    <div id="route66-seo-score"></div>
</div>
<div class="control-group mb-3 d-flex align-items-center col-12">
    <label for="link" class="col-2 pl-0 mb-0">Analysis</label>
    <div id="route66-seo-analysis"></div>
</div>


<link href="/route66/css/route66seo.css?1.9.1" rel="stylesheet" />
<script src="/route66/js/Route66SeoAnalyzerOptions.js"></script>
<script src="/route66/js/seo/main.min.js?1.9.1"></script>
<script src="/route66/js/seo/route66seo.js?1.9.1"></script>
<script>
@if (isset($content))
	Route66SeoAnalyzerOptions.url = "{{ $content->category->path }}/{{ $content->alias }}.html";
@else
	Route66SeoAnalyzerOptions.url = "";
@endif
</script>

<script>
	function getFirstParagraph() {
		var html = $('#ce').val();
		var temp = document.createElement('template');
		temp.innerHTML = html;
		if (temp && temp.content && temp.content.firstChild) {
			var meta_desc = temp.content.firstChild.innerHTML;
			$('#jform_metadesc').val(meta_desc);
		}
	}

	function analize_start() {
		$('#ce').val(CKEDITOR.instances.ce.getData());
		getFirstParagraph();
		Route66SeoAnalyzerOptions.url = $('#category').find(':selected').attr('data-alias') + '/{{ $content->alias ?? '' }}.html';
		$('#route66-seo-preview').html('');
		$('#route66-seo-score').html('');
		$('#route66-seo-analysis').html('');
		Route66SeoAnalyzer.start();
	}

	window.addEventListener('DOMContentLoaded', (event) => {
		analize_start();

		$( "#category" ).change(function() {
			analize_start();
		});

		CKEDITOR.instances.ce.on('change', function () {
			$('#route66-seo-preview').html('');
			$('#route66-seo-score').html('');
			$('#route66-seo-analysis').html('');
		});
	});
</script>

<style>
    .route66-seo-analysis-icon:before {
		content: "";
		display: inline-block;
		width: 15px;
		height: 15px;
		margin-right: 5px;
	}
	.route66-seo-analysis-score span.route66-seo-analysis-icon {
		margin-right: 8px;
	}

	.route66-seo-analysis-score-bad span.route66-seo-analysis-icon:before {
		background-color: #942a25;
	}

	.route66-seo-analysis-score-ok span.route66-seo-analysis-icon:before {
		background-color: #c67605;
	}

	.route66-seo-analysis-score-good span.route66-seo-analysis-icon:before {
		background-color: #378137;
	}
</style>
