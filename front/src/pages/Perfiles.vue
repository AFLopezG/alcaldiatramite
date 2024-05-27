<template>
    <q-page class="q-pa-xs">
        <div class="text-bold text-center text-h4">LISTA DE PERFILES DE USUARIO</div>     
        <div class="col-12">
            <q-table
                :rows="perfiles"
                :columns="columns"
                :filter="filter"
                row-key="name"
        >
        <template v-slot:body-cell-op="props">
            <q-td key="op" :props="props">
                <q-btn color="yellow" icon="edit" dense flat @click="perfil=props.row;dialogReg=true" />       
                <q-btn color="red" icon="delete" dense flat @click="eliminar(props.row)" />       
            </q-td>
        </template>
        <template v-slot:top-right>
            <span class="q-pa-xs"><q-btn color="green" icon="check" label="REGISTRAR" @click="perfil={}; dialogReg=true" dense /></span>
              <q-input outlined bottom-slots dense debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
        </q-table>
        <q-dialog v-model="dialogReg" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <q-avatar icon="list_alt" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm" v-if="perfil.id==undefined"> REGISTRAR PERFIL</span>
                    <span class="q-ml-sm" v-else>MODIFICAR PERFIL</span>
                </q-card-section>
                <q-form
                    @submit.prevent="registrar"
                    class="q-gutter-md"
                >

                <q-card-section>
                    <q-input v-model="perfil.prof" type="text" label="Descripcion" style="text-transform: uppercase;" required/>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="red" v-close-popup dense/>
                    <q-btn label="REGISTRAR" type="submit" color="green" dense flat v-if="perfil.id==undefined"/>
                    <q-btn label="MODIFCAR" type="submit" color="yellow" dense flat v-else />
                </q-card-actions>

                </q-form>
            </q-card>
        </q-dialog>
        </div>  
    </q-page>
</template>
<script>

    export default {
    name:'perfilPage',
    data() {
        return {
            perfiles:[],
            filter:'',
            perfil:{},
            dialogReg:false,
            columns:[
                {label:'ID',name:'id',field:'id'},
                {label:'PERFIL',name:'prof',field:'prof', align:'left'},
                {label:'OP',name:'op',field:'op'}
            ]
        }
    },
    created(){
        this.getProfile()
    },
    methods:{
        getProfile(){
            this.$q.loading.show()
        this.$api.get('profile').then(res => {
        this.perfiles=res.data
        this.$q.loading.hide()
      })
        },
        registrar(){
            if(this.perfil.id==undefined){
            this.$api.post('profile',this.perfil).then(() => {
            this.dialogReg=false
            this.perfil={}
            this.getProfile()
             })}
        else{
            this.$api.put('profile/'+this.perfil.id,this.perfil).then(() => {
            this.dialogReg=false
            this.perfil={}
            this.getProfile()
        })}

        },
        eliminar(pr){
            this.$q.dialog({
                title: 'Confirmar',
                message: 'Esta Seguro de Eliminar?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                this.$api.delete('profile/'+pr.id).then(() => {
                    this.getProfile()
                })

            }).onOk(() => {
                // console.log('>>>> second OK catcher')
            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
        }
    }

    
    }
</script>