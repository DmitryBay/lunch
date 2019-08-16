<?php
?>

<div class="fluid-container">

    <div class="maps"  >
        <div id="map"  ></div>
    </div>


</div>

<style>
    div#map {
        width: 100%; height: 100%;
    }
</style>
<script id="place-_view" type="text/x-jsrender">
{{for items}}
<div class="item" data-lat="{{:lat}}" data-lng="{{:lng}}" data-id="{{:id}}" data-title="{{:title}}" data-icon="">
    <a href="{{:url}}">{{:title}}</a> <br>{{:address}}{{if phone}}<br><i class="fa fa-phone"></i> {{:phone}}{{/if}}
</div>
{{else}}
  <div style="    padding: 5px 20px;">No places found!</div>
{{/for}}
</script>