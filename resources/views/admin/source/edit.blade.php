@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.source.actions.edit', ['name' => $source->id]))

@section('body')

    <div class="container-xl">

        <div class="card">

            <source-form
                :action="'{{ $source->resource_url }}'"
                :data="{{ $source->toJson() }}"
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="this.action" novalidate>

                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.source.actions.edit', ['name' => $source->id]) }}
                    </div>

                    <div class="card-block">

                        @include('admin.source.components.form-elements')

                    </div>

                    <div class="card-footer">
	                    <button type="submit" class="btn btn-primary" :disabled="submiting">
		                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
		                    {{ trans('brackets/admin-ui::admin.btn.save') }}
	                    </button>
                    </div>

                </form>

        </source-form>

    </div>

</div>

@endsection