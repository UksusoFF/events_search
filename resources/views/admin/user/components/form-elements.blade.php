<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email'), 'has-success': this.fields.email && this.fields.email.valid }">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <input type="text" v-model="form.email" v-validate="'required|email'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': this.fields.email && this.fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.user.columns.email') }}">
        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password'), 'has-success': this.fields.password && this.fields.password.valid }">
    <label for="password" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.password') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <input type="password" v-model="form.password" v-validate="'confirmed:password_confirmation|min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': this.fields.password && this.fields.password.valid}" id="password" name="password" placeholder="{{ trans('admin.user.columns.password') }}">
        <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password_confirmation'), 'has-success': this.fields.password_confirmation && this.fields.password_confirmation.valid }">
    <label for="password_confirmation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.password_repeat') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <input type="password" v-model="form.password_confirmation" v-validate="'confirmed:password_confirmation|min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': this.fields.password_confirmation && this.fields.password_confirmation.valid}" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('admin.user.columns.password') }}">
        <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city_id'), 'has-success': this.fields.city_id && this.fields.city_id.valid }">
    <label for="city_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.city_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <div>
            <textarea v-model="form.city_id" v-validate="''" @input="validate($event)" class="hidden-xs-up" id="city_id" name="city_id"></textarea>
            <quill-editor v-model="form.city_id" :options="wysiwygConfig" />
        </div>
        <div v-if="errors.has('city_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('token'), 'has-success': this.fields.token && this.fields.token.valid }">
    <label for="token" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.token') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <div>
            <textarea v-model="form.token" v-validate="''" @input="validate($event)" class="hidden-xs-up" id="token" name="token"></textarea>
            <quill-editor v-model="form.token" :options="wysiwygConfig" />
        </div>
        <div v-if="errors.has('token')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('token') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('first_name'), 'has-success': this.fields.first_name && this.fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.first_name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <input type="text" v-model="form.first_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': this.fields.first_name && this.fields.first_name.valid}" id="first_name" name="first_name" placeholder="{{ trans('admin.user.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('first_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('last_name'), 'has-success': this.fields.last_name && this.fields.last_name.valid }">
    <label for="last_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.last_name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <input type="text" v-model="form.last_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('last_name'), 'form-control-success': this.fields.last_name && this.fields.last_name.valid}" id="last_name" name="last_name" placeholder="{{ trans('admin.user.columns.last_name') }}">
        <div v-if="errors.has('last_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('last_name') }}</div>
    </div>
</div>

<div class="form-group row" :class="{'has-danger': errors.has('activated'), 'has-success': this.fields.activated && this.fields.activated.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-9'">
        <input class="form-check-input" id="activated" type="checkbox" v-model="form.activated" v-validate="''" data-vv-name="activated"  name="activated_fake_element">
        <label class="form-check-label" for="activated">
            {{ trans('admin.user.columns.activated') }}
        </label>
        <input type="hidden" name="activated" :value="form.activated">
        <div v-if="errors.has('activated')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('activated') }}</div>
    </div>
</div>

<div class="form-group row" :class="{'has-danger': errors.has('forbidden'), 'has-success': this.fields.forbidden && this.fields.forbidden.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-9'">
        <input class="form-check-input" id="forbidden" type="checkbox" v-model="form.forbidden" v-validate="''" data-vv-name="forbidden"  name="forbidden_fake_element">
        <label class="form-check-label" for="forbidden">
            {{ trans('admin.user.columns.forbidden') }}
        </label>
        <input type="hidden" name="forbidden" :value="form.forbidden">
        <div v-if="errors.has('forbidden')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('forbidden') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('language'), 'has-success': this.fields.language && this.fields.language.valid }">
    <label for="language" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.language') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <multiselect v-model="form.language" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_an_option') }}" :options="{{ $locales->toJson() }}" open-direction="bottom"></multiselect>
        <div v-if="errors.has('language')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('language') }}</div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('roles'), 'has-success': this.fields.roles && this.fields.roles.valid }">
    <label for="roles" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.user.columns.roles') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
        <multiselect v-model="form.roles" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" label="name" track-by="id" :options="{{ $roles->toJson() }}" :multiple="true" open-direction="bottom"></multiselect>
        <div v-if="errors.has('roles')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('roles') }}</div>
    </div>
</div>
