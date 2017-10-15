<template>
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="container-fluid">
                <fieldset title="Données générales" class="mt-20 pt-20">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <bs-input name="name" label="Nom"
                                          :error="check.error && 'Min. 6 chars'"
                                          :enter-submit="check.enterSubmit"
                                          :icon="check.icon"
                                          :label="check.label && 'Nom'"
                                          :mask="check.mask?mask:null"
                                          :minlength="check.minlength?6:0"
                                          pattern="^[a-z][a-z0-9]+$"
                                          :placeholder="check.placeholder"
                                          :readonly="check.readonly"
                                          :required="check.required"
                                          :hide-help="check.hideHelp"
                                          :value.sync="input"
                                >

                                </bs-input>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1">
                            <div class="checkbox-switch">
                                <label for="type" class="text-bold">Type de tournoi</label>
                                <br>
                                <input name="type" type="hidden" value="0" id="type">
                                <input class="switch"
                                       data-on-text="Ouvert"
                                       data-off-text="Invitation"
                                       name="type"
                                       type="checkbox"
                                       value="1" id="type">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="level_id" class="text-bold">Niveau</label>
                                <br>
                                <select class="form-control" id="level_id" name="level_id">
                                    <option value="1" selected="selected">ND</option>
                                    <option value="2">Local</option>
                                    <option value="3">Quartier</option>
                                    <option value="4">Municipal</option>
                                    <option value="5">État</option>
                                    <option value="6">Régional</option>
                                    <option value="7">National</option>
                                    <option value="8">International</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <!--Calendrier-->
                    <br>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="promoter" class="text-bold">Promoteur</label>
                                <br>
                                <bs-input name="promoter" type="text"
                                          id="promoter"></bs-input>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="host_organization"
                                       class="text-bold">Organisation hôte</label>
                                <br>
                                <bs-input name="host_organization" type="text"
                                          id="host_organization"></bs-input>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="technical_assistance"
                                       class="text-bold">Assistance technique</label>
                                <br>
                                <bs-input name="technical_assistance" type="text"
                                          id="technical_assistance"></bs-input>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div align="right">
                <button type="submit" class="btn btn-success">
                    Enregistrer
                </button>
            </div>
        </div>
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
        data() {
            return {
                check: {
                    error: true,
                    hideHelp: true,
                    icon: true,
                    label: true,
                    mask: true,
                    minlength: true,
                    required: true
                },
                event: null,
                input: null,
                match: null
            }
        },
        methods: {
            mask(value) {
                return value.toLowerCase().replace(/^[^a-z]+/, '').replace(/[^a-z0-9]/g, '')
            },

        },

    }
</script>