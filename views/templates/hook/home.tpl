{* views/templates/hook/home.tpl *}
<div class="card">
  <h3 class="card-header">
    {l s='Destinations' mod='dimsymfony'}
  </h3>
  <div class="card-body">
    <ul>
      {foreach from=$destinations item=destination}
        <li>{$destination.destination}</li>
      {/foreach}
    </ul>
  </div>
</div>
