<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': this.fields.type && this.fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('type'), 'form-control-success': this.fields.type && this.fields.type.valid}" id="type" name="type" placeholder="{{ trans('admin.source.columns.type') }}">
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': this.fields.user_id && this.fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': this.fields.user_id && this.fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.source.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('source'), 'has-success': this.fields.source && this.fields.source.valid }">
    <label for="source" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.source') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.source" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('source'), 'form-control-success': this.fields.source && this.fields.source.valid}" id="source" name="source" placeholder="{{ trans('admin.source.columns.source') }}">
        <div v-if="errors.has('source')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('source') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('map_id'), 'has-success': this.fields.map_id && this.fields.map_id.valid }">
    <label for="map_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.map_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.map_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('map_id'), 'form-control-success': this.fields.map_id && this.fields.map_id.valid}" id="map_id" name="map_id" placeholder="{{ trans('admin.source.columns.map_id') }}">
        <div v-if="errors.has('map_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('map_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('map_title'), 'has-success': this.fields.map_title && this.fields.map_title.valid }">
    <label for="map_title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.map_title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.map_title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('map_title'), 'form-control-success': this.fields.map_title && this.fields.map_title.valid}" id="map_title" name="map_title" placeholder="{{ trans('admin.source.columns.map_title') }}">
        <div v-if="errors.has('map_title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('map_title') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('map_desc'), 'has-success': this.fields.map_desc && this.fields.map_desc.valid }">
    <label for="map_desc" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.map_desc') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.map_desc" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('map_desc'), 'form-control-success': this.fields.map_desc && this.fields.map_desc.valid}" id="map_desc" name="map_desc" placeholder="{{ trans('admin.source.columns.map_desc') }}">
        <div v-if="errors.has('map_desc')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('map_desc') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('map_image'), 'has-success': this.fields.map_image && this.fields.map_image.valid }">
    <label for="map_image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.map_image') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.map_image" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('map_image'), 'form-control-success': this.fields.map_image && this.fields.map_image.valid}" id="map_image" name="map_image" placeholder="{{ trans('admin.source.columns.map_image') }}">
        <div v-if="errors.has('map_image')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('map_image') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('map_date'), 'has-success': this.fields.map_date && this.fields.map_date.valid }">
    <label for="map_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.source.columns.map_date') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.map_date" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('map_date'), 'form-control-success': this.fields.map_date && this.fields.map_date.valid}" id="map_date" name="map_date" placeholder="{{ trans('admin.source.columns.map_date') }}">
        <div v-if="errors.has('map_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('map_date') }}</div>
    </div>
</div>


