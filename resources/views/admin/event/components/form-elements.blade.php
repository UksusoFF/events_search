<div class="form-group row align-items-center" :class="{'has-danger': errors.has('vid'), 'has-success': this.fields.vid && this.fields.vid.valid }">
    <label for="vid" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.event.columns.vid') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.vid" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('vid'), 'form-control-success': this.fields.vid && this.fields.vid.valid}" id="vid" name="vid" placeholder="{{ trans('admin.event.columns.vid') }}">
        <div v-if="errors.has('vid')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('vid') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': this.fields.name && this.fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.event.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': this.fields.name && this.fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.event.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('description'), 'has-success': this.fields.description && this.fields.description.valid }">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.event.columns.description') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.description" v-validate="'required'" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('photo_200'), 'has-success': this.fields.photo_200 && this.fields.photo_200.valid }">
    <label for="photo_200" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.event.columns.photo_200') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.photo_200" v-validate="'required'" id="photo_200" name="photo_200" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('photo_200')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('photo_200') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('start_date'), 'has-success': this.fields.start_date && this.fields.start_date.valid }">
    <label for="start_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.event.columns.start_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.start_date" :config="datetimePickerConfig" v-validate="'date_format:YYYY-MM-DD HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('start_date'), 'form-control-success': this.fields.start_date && this.fields.start_date.valid}" id="start_date" name="start_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('start_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('start_date') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('ignored'), 'has-success': this.fields.ignored && this.fields.ignored.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="ignored" type="checkbox" v-model="form.ignored" v-validate="''" data-vv-name="ignored"  name="ignored_fake_element">
        <label class="form-check-label" for="ignored">
            {{ trans('admin.event.columns.ignored') }}
        </label>
        <input type="hidden" name="ignored" :value="form.ignored">
        <div v-if="errors.has('ignored')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ignored') }}</div>
    </div>
</div>


