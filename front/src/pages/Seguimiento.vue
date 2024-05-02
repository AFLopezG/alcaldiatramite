<template>
    <q-page class="q-pa-xs">
      <div class="text-h5 text-center text-bold">SEGUIMIENTO DE TRAMITE</div>
        <div class="row " align="center">
        <div class="col-md-3 col-xs-6 q-pa-xs"> <q-input class="inputPrice" v-model="buscar.numero" type="number" label="Numero de Tramite" outlined dense  /> </div>
        <div class="col-md-2 col-xs-4 q-pa-xs"> <q-input class="inputPrice" v-model="buscar.gestion" type="number" label="Gestion" outlined dense  /> </div>
        <div class="col-md-6 col-xs-4 q-pa-xs"> <q-select  v-model="tramite" label="Tramite" outlined dense  :options="tramites"/> </div>
        <div class="col-md-1 col-xs-2">
            <q-btn color="info" icon="search"  @click="buscarTramite()" dense/>
        </div>
        </div>

      <div class="row">

        <div class="q-pa-md" v-if="propietario.id!=undefined">
            <b>PROPIETARIO: </b> {{propietario.nombre }} {{ propietario.apellido }}<br>
        </div>
        <div class="col-12" v-if="formularios.length>0">
          <q-table
            table-header-style="background-color: #009e91;"
            title="LISTADO DE TRAMITES"
            :rows="formularios"
            :columns="colForm"
            row-key="name"
            dense
          >
          <template v-slot:body-cell-op="props">
            <q-td key="op" :props="props">
                <q-btn color="info" icon="visibility" size="xs" @click="conLog(props.row)"  />
                <q-btn color="red" icon="delete" size="xs" @click="eliminar(props.row)" v-if="store.booldelete"/>
            </q-td>

        </template>
        </q-table>

        </div>
        <div class="q-pa-md" v-if="formulario.id!=undefined">
            <b>TRAMITE: </b> {{ formulario.tramite.nombre }} <br>
            <b>CODIGO: </b> {{ formulario.codtram }} <br>
            <b>DETALLE: </b> {{ formulario.detalle }} <br>
            <b>OBSERVACION: </b> {{ formulario.observacion }}
        </div>
        <div class="col-12" v-if="formulario.id!=undefined">
          <q-table
            dense
            table-header-style="background-color: #009e91;"
            title="Seguimiento Tramite"
            :rows="formulario.logs"
            :columns="columns"
            :filter="filter"
            :loading="loading"
            :rows-per-page-options="[10,100,150,200,0]"
             row-key="name">
            <template v-slot:top-right>
              <q-input outlined bottom-slots dense debounce="300" v-model="filter" @keyup.enter="buscar" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon v-if="filter !== ''" name="close" @click="actualizar" class="cursor-pointer" />
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
          </q-table>
        </div>
      </div>
    </q-page>
  </template>
  <script>
  import {date} from 'quasar'
import { globalStore } from '../stores/globalStore'
export default {
    name: 'seguimientoPage',
    data(){
      return {
        buscar: {'gestion':date.formatDate(Date.now(),'YYYY')},
        propietario:{},
        tramites:[],
        tramite:{label:''},
        filter:'',
        filter2:'',
        usuario:'',
        formularios:[],
        store: globalStore(),
        colForm:[
            {name:'op',field:'op',label:'OP',align:'left'},
            {name:'fecha',field:'fecha',label:'FECHA',align:'left'},
            {name:'codigo',field:'codigo',label:'CODIGO',align:'left'},
            {name:'tramite',field:row=>row.tramite.nombre,label:'TRAMITE',align:'left'},
            {name:'estado',field:'estado',label:'ESTADO',align:'left'},
            {name:'observacion',field:'observacion',label:'OBS',align:'left'},

        ],
        columns:[
          {name:'fecha',field:'fecha',label:'FECHA',align:'left'},
          {name:'hora',field:'hora',label:'HORA',align:'left'},
          {name:'cargo',field: row=>row.cargo.nombre,label:'CARGO',align:'left'},
          {name:'usuario',field: row=>row.user2.name,label:'USUARIO',align:'left'},
          {name:'obs',field:'obs',label:'OBSERVACION',align:'left'}
        ],

        formulario:{},
        formulario2:[],
        loading:false
      }
    },
    created() {
      this.getTramites()
    },
    methods:{
      eliminar(formulario ){
        this.$q.dialog({
        title: 'CONFIRMAR',
        message: 'Esta Seguro de Eliminar?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        // console.log('>>>> OK')
        this.$api.delete('formulario/'+formulario.id).then(() => {
          this.$q.notify({
            message: 'EL TRAMITE ELIMINADO',
            color: 'negative',
            position: 'top',
            icon:'info'
            }) 
            this.buscarTramite()
        })
      }).onOk(() => {
        // console.log('>>>> second OK catcher')
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
      },
      conLog(tram){
        console.log(tram)
        //return false
        this.$api.post('consprop',{'id': tram.id}).then((res) => {
            console.log(res.data)
            this.formulario=res.data
        })

      },
        getTramites(){
        this.tramites=[]
        this.$api.post('unitTramite').then((res) => {
          res.data.forEach(r => {
            r.label=r.nombre
            this.tramites.push(r)
          })

        })
      },

      buscarTramite(){
        this.formulario=[]
        if(this.tramite.id==undefined)
          return false
        if(this.buscar.numero==undefined )
            return false
        if(this.buscar.gestion < 1900 && this.buscar.gestion > 9999 )
            return false
        this.buscar.tramite_id=this.tramite.id
         this.$api.post('listForm2',this.buscar).then((res) => {
          console.log(res.data)
            if(res.data=='')
            this.$q.notify({
            message: 'No existen Tramites',
            color: 'negative',
            position: 'top',
            icon:'info'
            })
            this.formularios=res.data

        })
      },

    }
  };
  </script>
  <style scoped>
  .inputPrice  input[type='number'] {
  -moz-appearance: textfield;
    }
    .inputPrice  input::-webkit-outer-spin-button,
    .inputPrice  input::-webkit-inner-spin-button {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
    }
</style>