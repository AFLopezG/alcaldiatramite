<template>
    <q-page class="q-pa-xs">
      <div class="text-h5 text-center text-bold">SEGUIMIENTO DE TRAMITE</div>
        <div class="row " align="center">
        <div class="col-md-10 col-xs-12 q-pa-xs"> <q-input  v-model="buscar"  label="Ingrese codigo / cedula / nombre o apellido" outlined dense  /> </div>
        <div class="col-md-1 col-xs-2">
            <q-btn color="info" icon="search"  @click="buscarTramite()" dense/>
        </div>
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
                <q-btn color="info" icon="visibility" size="xs" @click="getHistorial(props.row)"  />
            </q-td>

        </template>
        </q-table>

        </div>


          <q-dialog v-model="dialogHist" >
            <q-card style="width: 700px; max-width: 100%;">
                <q-card-section class="row items-center">
                    <q-avatar icon="timeline" color="primary" text-color="white" size="sm"   />
                    <span class="q-ml-sm">HISTORIAL DE ENVIOS {{ formulario.codigo }}</span>
                </q-card-section>
                <q-card-section style="max-height: 60vh" class="scroll">
                  <div>Tramite: {{ formulario.tramite.nombre }}</div>
                  <div>Propietario: {{ formulario.propietario.nombre }} {{ formulario.propietario.apellido }}</div>
                    <q-timeline layout="comfortable" side="right" color="secondary" style="font-size: 12px;" dense>
                        <q-timeline-entry
                            :title="hist.proceso.nombre"
                            :subtitle="hist.fecha +' '+ hist.hora"
                            side="left"
                            :icon="hist.estado=='EN PROCESO'?'engineering': hist.estado=='CANCELADO'?'block':hist.estado=='FINALIZADO'?'check_circle_outline':''"
                            :color="hist.color"
                            v-for="hist in historial" :key="hist"
                            
                        >
                            <div>
                                <span>{{ hist.user2.name }}</span><br>
                                <q-badge :color="hist.color"  text-color="{2:black}" :label=" hist.estado " dense/> <br>
                                {{ hist.obs }}
                            </div>
                        </q-timeline-entry>
                    </q-timeline>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancelar" color="red" v-close-popup dense />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
  </template>
  <script>
import { globalStore } from '../stores/globalStore'
export default {
    name: 'seguimientoPage',
    data(){
      return {
        buscar: '',
        historial:[],
        formulario1:{},
        propietario:{},
        tramites:[],
        dialogremitir:false,
        dialogHist:false,
        tramite:{label:''},
        filter:'',
        filter2:'',
        usuario:{label:''},
        usuarios:[],
        usuarios2:[],
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

    methods:{
      getHistorial(dato){
        this.formulario=dato
            this.$api.get('log/'+dato.id).then((res) => { 
                console.log(res.data)
                res.data.forEach( r => {
                    r.color='black'
                    if(r.estado=='EN PROCESO') r.color='green'
                    if(r.estado=='RECTIFICAR' || r.estado=='CANCELADO' || r.estado=='RECHAZADO') r.color='red'
                    if(r.estado=='FINALIZADO') r.color='green'
                    if(r.estado=='DERIVADO') r.color='indigo'
                    if(r.estado=='CAMBIO') r.color='amber-8'
                });
                this.historial=res.data
                this.dialogHist=true
            })           
        },

      buscarTramite(){
        this.formulario=[]
        if(this.buscar.length<3){
        this.$q.notify({
            message: 'Ingrese un valor mayor 3 caracteres',
            color: 'negative',
            position: 'top',
            icon:'info'
            })
          }
         this.$api.post('listForm',{searchtext:this.buscar}).then((res) => {
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