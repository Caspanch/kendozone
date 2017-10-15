<template>
    <div>
        <tabs><!--  active.sync="active" -->
            <tab header="General">
                <tournament-tab-general></tournament-tab-general>
            </tab>
            <tab header="Lieu">
                <p>
                    lieu
                </p>
            </tab>
            <tab header="Categories">
                <p>
                    categories
                </p>
            </tab>
            <tab header="Parametres">
                <p>
                    parametres
                </p>
            </tab>
        </tabs>
    </div>
</template>

<script>
    import {tab, tabs, formGroup, input, alert} from "vue-strap";

    export default {
        components: {
            tab: tab,
            tabs: tabs,
            formGroup: formGroup,
            bsInput: input,
            alert: alert
        },
        data () {
            return {
                check: {
                    clearButton:true,
                    error:true,
                    hideHelp: true,
                    icon:true,
                    label:true,
                    mask:true,
                    minlength:true,
                    placeholder:true,
                    required:true
                },
                event: null,
                input: null,
                match: null
            }
        },
        methods: {
            mask (value) {
                return value.toLowerCase().replace(/^[^a-z]+/,'').replace(/[^a-z0-9]/g,'')
            }
        }
    }
</script>