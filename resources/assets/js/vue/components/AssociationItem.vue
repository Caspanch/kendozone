<template>
    <tr v-if="isVisible">
        <td>
            <!--@if (Auth::user().isSuperAdmin() || Auth::user().isFederationPresident())-->
            <a :href=url_edit>{{ association.name }}</a>
            <!--@else-->
            <!--{{ association.name }}-->
            <!--@endif-->
        </td>
        <td align="center">{{ association.federation != null ? association.federation.name : " - "}}</td>
        <td align="center">{{ association.president != null ? association.president.name : " - "}}</td>
        <td align="center">{{ association.president != null ? association.president.email : " - " }}</td>
        <td align="center">{{ association.address }}</td>
        <td align="center">{{ association.phone }}</td>
        <td align="center">
            <div v-if="association.federation !=null && association.federation.country !=null">
                <img :src=flag >
            </div>
            <div v-else>&nbsp;</div>
        </td>
        <td align="center">
            <!--@can('edit', association)-->
            <a :href=url_edit><i class="icon icon-pencil7"></i></a>
            <!--@endcan-->
            <!--@can('delete', association)-->
            <button type="submit" class="btn text-warning-600 btn-flat" @click="deleteItem(association.id)">
                <i :class=spinnerOrIcon></i></button>

            <!--@endcan-->
        </td>

    </tr>
</template>
<script>
    export default {
        props: ['association', 'url_edit', 'url_delete'],

        data() {
            return {
                isVisible: true,
                isRequesting: true,
            }
        },
        computed: {
            flag() {
                return '/images/flags/' + this.association.federation.country.flag;
            },
            spinnerOrIcon() {
                return this.isRequesting
                    ? 'glyphicon glyphicon-trash'
                    : 'icon-spinner spinner position-left';
            }
        },

        methods: {
            deleteItem(associationId) {
                const vm = this;
                axios.post(this.url_delete, function () {
                    vm.isRequesting = true;
                })
                    .then(function (data) {
                        vm.isRequesting = false;
                        vm.isVisible = false;
                        flash(data.data.msg)
                    })
                    .catch(function (data) {
                        vm.isVisible = true;
                        vm.isRequesting = false;
                        flash(data.msg, 'error')
                    });
            },
        },

    }
</script>