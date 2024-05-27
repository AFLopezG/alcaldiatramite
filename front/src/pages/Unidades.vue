<template>
    <q-page class="q-pa-xs">
        <div class="text-center text-bold text-h5">LISTA DE UNIDADES</div>
        <div class="q-pa-xs">
            <q-table
                :rows="units"
                :columns="columns"
                row-key="name"
            >
            <template v-slot:body-cell-op="props">
            <q-td key="op" :props="props">
                <q-btn color="yellow" icon="edit" dense flat @click="unit=props.row;dialogReg=true" />       
                <q-btn color="red" icon="delete" dense flat @click="eliminar(props.row)" />       
            </q-td>
        </template>
        <template v-slot:top-right>
            <span class="q-pa-xs"><q-btn color="green" icon="check" label="REGISTRAR" @click="unit={}; dialogReg=true" dense /></span>
              <q-input outlined bottom-slots dense debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            </q-table>
        </div>
        <q-dialog v-model="dialogReg" persistent>
            <q-card style="width: 700px; max-width: 80vw;">
                <q-card-section class="row items-center">
                    <q-avatar icon="list_alt" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm" v-if="unit.id==undefined"> REGISTRAR UNIDAD</span>
                    <span class="q-ml-sm" v-else>MODIFICAR UNIDAD</span>
                </q-card-section>
                <q-form
                    @submit.prevent="registrar"
                    class="q-gutter-md"
                >

                <q-card-section>
                    <q-input v-model="unit.nombre" type="text" label="Nombre" style="text-transform: uppercase;"  required/>
                    <q-input v-model="unit.codigo" type="text" label="Codigo" style="text-transform: uppercase;"  required/>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="red" v-close-popup dense/>
                    <q-btn label="REGISTRAR" type="submit" color="green" dense flat v-if="unit.id==undefined"/>
                    <q-btn label="MODIFCAR" type="submit" color="yellow" dense flat v-else />
                </q-card-actions>

                </q-form>
            </q-card>
        </q-dialog>
    </q-page>
</template>
<script>
export default {
    name:'unitPage',
    data() {
        return {
            units:[],
            unit:{},
            dialogReg:false,
            filter:'',
            columns:[
                {label:'OP',name:'op',field:'op'},
                {label:'NOMBRE',name:'nombre',field:'nombre',align:'left'},
                {label:'CODIGO',name:'codigo',field:'codigo'}
            ]            
        }
    },
    created(){
        this.getUnits()
    },
    methods: {
      getUnits(){
        this.$q.loading.show()
        this.$api.get('unit').then((res) => {
            console.log(res.data)
            this.units=res.data
            this.$q.loading.hide()
        })
      },  
      registrar(){
        if(this.unit.id==undefined){
            this.$api.post('unit',this.unit).then(() => {
                this.dialogReg=false
                this.unit={}
             this.getUnits()
        }).catch(err => {
            console.log(err)
          this.$q.notify({
            message: err.response.data.message
            ,
            icon: 'close',
            color: 'red'
          })
        })
        }
        else{
            this.$api.put('unit/'+this.unit.id,this.unit).then(() => {
                this.dialogReg=false
                this.unit={}
             this.getUnits()
        })
        }
      },  
      eliminar(p){
        this.$q.dialog({
                title: 'Confirmar',
                message: 'Esta Seguro de Eliminar?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                this.$api.delete('unit/'+p.id).then(() => {
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
    },
}
</script>