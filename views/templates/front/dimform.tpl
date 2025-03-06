
{extends file='page.tpl'}

{block name="page_title"}
  {l s='Book an Appointment' d='Modules.Dimsymfony.Shop'}
{/block}

{block name="page_content"}
  <div class="card">
    <div class="card-header">
      <h1 class="h4">{l s='Book an Appointment' d='Modules.Dimsymfony.Shop'}</h1>
    </div>
    <div class="card-body">
      {if isset($confirmation_message)}
        <div class="alert alert-success">
          {$confirmation_message}
        </div>
      {/if}
      
      {if isset($errors) && $errors}
        <div class="alert alert-danger">
          <ul class="mb-0">
            {foreach $errors as $error}
              <li>{$error}</li>
            {/foreach}
          </ul>
        </div>
      {/if}
      
      <form action="{$link->getModuleLink('dimsymfony', 'dimform')}" method="post" class="needs-validation" novalidate>
        <div class="form-group row">
          <div class="col-md-6 mb-3">
            <label for="lastname">{l s='Last Name' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="{$formValues.lastname|escape:'html':'UTF-8'}" required>
            <div class="invalid-feedback">
              {l s='Please provide a valid last name.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="firstname">{l s='First Name' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="{$formValues.firstname|escape:'html':'UTF-8'}" required>
            <div class="invalid-feedback">
              {l s='Please provide a valid first name.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
        </div>
        
        <div class="form-group mb-3">
          <label for="address">{l s='Address' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="address" name="address" value="{$formValues.address|escape:'html':'UTF-8'}" required>
          <div class="invalid-feedback">
            {l s='Please provide a valid address.' d='Modules.Dimsymfony.Shop'}
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-6 mb-3">
            <label for="postal_code">{l s='Postal Code' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{$formValues.postal_code|escape:'html':'UTF-8'}" required>
            <div class="invalid-feedback">
              {l s='Please provide a valid postal code.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="city">{l s='City' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="city" name="city" value="{$formValues.city|escape:'html':'UTF-8'}" required>
            <div class="invalid-feedback">
              {l s='Please provide a valid city.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-6 mb-3">
            <label for="phone">{l s='Phone' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{$formValues.phone|escape:'html':'UTF-8'}" required>
            <div class="invalid-feedback">
              {l s='Please provide a valid phone number.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="email">{l s='Email' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="{$formValues.email|escape:'html':'UTF-8'}" required>
            <div class="invalid-feedback">
              {l s='Please provide a valid email address.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-6 mb-3">
            <label for="date_creneau1">{l s='Preferred Time Slot 1' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <select class="form-control" id="date_creneau1" name="date_creneau1" required>
              <option value="">{l s='-- Select a time slot --' d='Modules.Dimsymfony.Shop'}</option>
              {foreach from=$date_options item=option}
                <option value="{$option.value}" {if $formValues.date_creneau1 eq $option.value}selected{/if}>{$option.label}</option>
              {/foreach}
            </select>
            <div class="invalid-feedback">
              {l s='Please select a time slot.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="date_creneau2">{l s='Preferred Time Slot 2' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span></label>
            <select class="form-control" id="date_creneau2" name="date_creneau2" required>
              <option value="">{l s='-- Select a time slot --' d='Modules.Dimsymfony.Shop'}</option>
              {foreach from=$date_options item=option}
                <option value="{$option.value}" {if $formValues.date_creneau2 eq $option.value}selected{/if}>{$option.label}</option>
              {/foreach}
            </select>
            <div class="invalid-feedback">
              {l s='Please select a time slot.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
        </div>
        
        <div class="form-group mb-3">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="gdpr_consent" name="gdpr_consent" value="1" {if $formValues.gdpr_consent}checked{/if} required>
            <label class="custom-control-label" for="gdpr_consent">
              {l s='I agree to the processing of my personal data for appointment scheduling purposes.' d='Modules.Dimsymfony.Shop'} <span class="text-danger">*</span>
              <a href="{$gdpr_link}" target="_blank">{l s='Read our privacy policy' d='Modules.Dimsymfony.Shop'}</a>
            </label>
            <div class="invalid-feedback">
              {l s='You must agree before submitting.' d='Modules.Dimsymfony.Shop'}
            </div>
          </div>
        </div>
        
        <div class="form-group text-center">
          <button type="submit" name="submit_dimrdv" class="btn btn-primary">
            {l s='Book Now' d='Modules.Dimsymfony.Shop'}
          </button>
        </div>
      </form>
    </div>
  </div>
  
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
{/block}
