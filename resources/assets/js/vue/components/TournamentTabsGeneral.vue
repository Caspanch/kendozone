<template>
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="container-fluid">
                <fieldset title="Données générales" class="mt-20 pt-20">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <bs-input name="name"
                                          label="Nom"
                                          :error="check.error && 'Min. 6 chars'"
                                          :enter-submit="check.enterSubmit"
                                          :icon="check.icon"
                                          :label="check.label && 'Nom'"
                                          :minlength="check.minlength?6:0"
                                          :placeholder="check.placeholder"
                                          :required="check.required"
                                          :hide-help="check.hideHelp"
                                          :value.sync="input"
                                >

                                </bs-input>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="text-bold">Type de tournoi</label>
                            <select class="form-control" id="type" name="type">
                                <option value="0" selected="selected">Invitation</option>
                                <option value="1" selected="selected">Open</option>
                            </select>
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
                    <div class="row">
                        <div class="col-md-4">
                            <label>From</label>
                            <datepicker name="dateIni"
                                        :value.sync="dateIni.value"
                                        :format="dateIni.format"
                                        :clear-button="dateIni.clear"
                                        :placeholder="dateIni.placeholder">
                            </datepicker>
                        </div>
                        <div class="col-md-4">
                            <label>To</label>
                            <datepicker name="registerDateLimit"
                                        :value.sync="dateIni.value"
                                        :format="dateIni.format"
                                        :clear-button="dateIni.clear"
                                        :placeholder="dateIni.placeholder">
                            </datepicker>
                        </div>
                        <div class="col-md-4">
                            <label>Max Registration</label>

                            <datepicker name="dateFin"
                                        :value.sync="dateIni.value"
                                        :format="dateIni.format"
                                        :clear-button="dateIni.clear"
                                        :placeholder="dateIni.placeholder">
                            </datepicker>
                        </div>
                    </div>
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
    import {tab, tabs, formGroup, input, alert, datepicker} from "vue-strap";

    export default {
        components: {
            tab,
            tabs,
            formGroup,
            bsInput: input,
            alert,
            datepicker
        },
        data() {
            return {
                check: {
                    error: true,
                    hideHelp: true,
                    icon: true,
                    label: true,
                    mask: false,
                    minlength: true,
                    required: true
                },
                i18n: {
                    night: 'Night',
                    nights: 'Nights',
                    'day-names': ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                    'check-in': 'From',
                    'check-out': 'To',
                    'month-names': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                },
                dateIni: {
                    disabled: [],
                    value: '2015-06-10',
                    formats: [
                        {value: 'dd/MM/yyyy', label: 'dd/MM/yyyy'},
                        {value: 'dd-MM-yyyy', label: 'dd-MM-yyyy'},
                        {value: 'yyyy,MM,dd', label: 'yyyy,MM,dd'},
                        {value: 'yyyy-MM-dd', label: 'yyyy-MM-dd'},
                        {value: 'yyyy.MM.dd', label: 'yyyy.MM.dd'},
                        {value: 'MMM/dd/yyyy', label: 'MMM/dd/yyyy'},
                        {value: 'MMMM/dd/yyyy', label: 'MMMM/dd/yyyy'},
                        {value: 'MM/dd/yyyy', label: 'MM/dd/yyyy'},
                        {value: 'MM-dd-yyyy', label: 'MM-dd-yyyy'}
                    ],
                    format: ['yyyy-MM-dd'],
                    clear: true,
                    placeholder: 'What is first day of your tournament'
                },
                hoveringTooltip: false,
                event: null,
                input: null,
                match: null,
            }
        },
        methods: {},

    }
</script>