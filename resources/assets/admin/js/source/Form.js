import AppForm from '../app-components/Form/AppForm';

Vue.component('source-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                type:  '' ,
                user_id:  '' ,
                source:  '' ,
                map_id:  '' ,
                map_title:  '' ,
                map_desc:  '' ,
                map_image:  '' ,
                map_date:  '' ,
                
            }
        }
    }

});