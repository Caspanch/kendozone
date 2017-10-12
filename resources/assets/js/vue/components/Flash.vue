<template>
    <div>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                id: null,
                body: this.message,
                level: 'success',
                url: null,
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash();
            }

            window.events.$on(
                'flash', data => this.flash(data)
            );
        },

        methods: {
            flash(data) {

                let icon = "<i class='icon-trophy2'>";
                if (data.level === 'error') {
                    icon = "<i class='icon-warning'>";
                }
                let timeout = 5000;
                let closeWith = ['click'];
                let template = `<div class="noty_message">
                         <div class="row">
                             <div class="col-xs-4 noty_icon"> ${ icon } </i> </div>
                             <div class="col-xs-8"><span class="noty_text"></span>
                             <div class="noty_close"></div>
                         </div>
                     </div>`;
                if (data.url) {
                    template = `<div class="noty_message">
                                     <div class='row'>
                                         <div class='col-xs-8'> ${ data.message } </div>
                                         <div class='col-xs-3' align='right'>
                                             <a class='undo' onclick="undoAction('${ data.url }','${ data.itemId }')">
                                                 <span class='undo_link'>UNDO</span></a>
                                         </div>
                                     </div>
                                 </div>`;


                    // TODO Translate
                    timeout = 10000;
                    closeWith = ['button'];
                }
                noty({
                    layout: 'bottomLeft',
                    theme: 'kz',
                    type: data.level,
                    width: 200,
                    dismissQueue: true,
                    timeout: timeout,
                    text: data.message,
                    force: true,
                    killer: true,
                    closeWith: closeWith,
                    template: template
                });
            },
        }
    };
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>