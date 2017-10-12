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
                const vm = this;
                this.isRequesting = true;
                axios.post(this.url_delete, function () {
                })
                    .then(function (response) {
                        if (response.data !== null && response.data.status === 'success') {
                            vm.isRequesting = false;
                            vm.isVisible = false;
                            flash('Item deleted!','success',vm.url_undo, associationId);
                            return;
                        }
                        vm.isVisible = true;
                        vm.isRequesting = false;
                        return flash('Failed deleting item 1','error')

                    })
                    .catch(function (response) {
                        vm.isVisible = true;
                        vm.isRequesting = false;
                        console.log(response);
                        flash('Failed deleting item 2','error')

                    });
            },
            restoreItem(data){
                if (this.association.id != data.itemId) return; // Don't move cohertion
                const vm = this;
                this.isRequesting = true;
                axios.post(data.url, function () {
                })
                    .then(function (response) {
                        if (response.data !== null && response.data.status === 'success') {
                            vm.isRequesting = false;
                            vm.isVisible = true;
                            return flash('Item restored')

                        }
                        vm.isVisible = false;
                        vm.isRequesting = false;
                        return flash('Item not restored','error')


                    })
                    .catch(function (response) {
                        vm.isVisible = false;
                        vm.isRequesting = false;
                        flash('hello billo')

                    });
            },
            initTable:function()
            {
                $('.table-togglable').footable();
            }
        },

        mounted() {
            window.events.$on(
                'undo', data => this.restoreItem(data)
            );
            $('.table-togglable').footable();


        },
        watch:
            {
                show:function(state, old)
                {
                    console.log('watch');
                    if(state) this.initTable();
                }
            },
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