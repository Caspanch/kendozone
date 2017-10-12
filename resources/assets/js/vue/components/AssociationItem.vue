<template>
    <transition name="slide-fade">
        <tr v-if="isVisible">
            <td> <slot name="name"></slot> </td>
            <td align="center">{{ association.federation != null ? association.federation.name : " - "}}</td>
            <td align="center">{{ association.president != null ? association.president.name : " - "}}</td>
            <td align="center">{{ association.president != null ? association.president.email : " - " }}</td>
            <td align="center">{{ association.address }}</td>
            <td align="center">{{ association.phone }}</td>
            <td align="center">
                <div v-if="association.federation !=null && association.federation.country !=null">
                    <img :src=flag>
                </div>
                <div v-else>&nbsp;</div>
            </td>
            <td align="center">
                <!--@can('edit', association)-->
                <a :href=url_edit><i class="icon icon-pencil7"></i></a>
                <!--@endcan-->
                <!--@can('delete', association)-->
                <button class="btn text-warning-600 btn-flat" @click="deleteItem(association.id)">
                    <i :class=spinnerOrIcon></i></button>
                <!--@endcan-->
            </td>
        </tr>
    </transition>
</template>
<script>
    import Toasted from 'vue-toasted';
    let options = {
        type : 'success',
        position: 'bottom-left',
        duration: 5000,
        action : {
            text : 'Cancel',
            onClick : (e, toastObject) => {
                toastObject.goAway(0);
            }
        },
    };
    Vue.use(Toasted,options);

    export default {
        props: ['association', 'url_edit', 'url_delete', 'url_undo'],

        data() {
            return {
                isVisible: true,
                isRequesting: false,
            }
        },
        computed: {
            flag() {
                return '/images/flags/' + this.association.federation.country.flag;
            },
            spinnerOrIcon() {
                return this.isRequesting
                    ? 'icon-spinner spinner position-left'
                    : 'glyphicon glyphicon-trash';
            }
        },
        methods: {
            deleteItem(associationId) {
                deleteItem()
            },
            restoreItem(url_restore){

            },
        },
        mounted() {
            $('.table-togglable').footable();
        }
    }
</script>
<style>
    .slide-fade-enter-active {
        transition: all .3s ease;
    }

    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */
    {
        transform: translateX(10px);
        opacity: 0;
    }
</style>