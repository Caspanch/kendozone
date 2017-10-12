@if(Session::has('flash_message'))
    <script src="https://unpkg.com/vue-toasted"></script>

    <script>
        {{--Vue.use(Toasted,{--}}
            {{--type : 'success',--}}
            {{--position: 'bottom-left',--}}
            {{--duration: 5000,--}}
        {{--});--}}
        {{--Vue.toasted.show("{!!  session('flash_message.message')!!}");--}}
        {{--text: ,--}}

//        Toast.show("Toasted !!", {
//            theme: "primary",
//            position: "top-right",
//            duration : 5000
//        });
//        Vue.use(Toasted

        flash("{!!  session('flash_message.message')!!}");
    </script>
@endif