import AppForm from '../app-components/Form/AppForm';

Vue.component('event-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                vid:  '' ,
                name:  '' ,
                description:  '' ,
                photo_200:  '' ,
                start_date:  '' ,
                ignored:  false ,
                
            }
        }
    }

});