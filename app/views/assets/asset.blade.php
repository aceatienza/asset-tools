<!-- hello from the subview -->
<h3>{{ link_to_route('control.asset.edit', $asset->name, array($asset->id), array('class' => '')) }}</h3>
@if (isset($asset->path) && $asset->path != null)
    <img src="{{ $asset->path.'/'.$asset->filename }}" alt="">
@elseif (isset($asset->vimeo_thumbnail))
    <img src="{{ urldecode($asset->vimeo_thumbnail) }}" alt="{{ $asset->vimeo_title }}">
        <br>
    <!-- <span>Vimeo Title: </span><a href="{{ urldecode($asset->vimeo_url) }}">{{ urldecode($asset->vimeo_title) }}</a> -->
        <!-- TODO: replace thumbnail with Vimeo player -->
@endif