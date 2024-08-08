<template>
    <q-layout class="q-pa-xs" view="lHh Lpr lFf">
      <q-header elevated>
        <q-toolbar>
            <q-toolbar-title>
            <div class="row">
              <div class=""> <img src="/logo.png" style="height: 40px; width: 40px;" /></div>
              <div class="">GOBIERNO AUTONOMO MUNICIPAL DE ORURO <br><div style="font-size:10px"></div></div>
            </div>
          </q-toolbar-title>

        </q-toolbar>
      </q-header>
      <q-page-container>
      <q-page>
    <div class="text-h5 text-center text-bold">SEGUIMIENTO DE TRAMITE</div>
        <div class="row " align="center">
        <div class="col-md-9  q-pa-xs"> <q-input v-model="codigo" label="Codigo / Cedula / Nombre" outlined dense  /> </div>
        <div class="col-md-3 ">
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
                <q-btn color="info" icon="visibility" size="xs" @click="getHistorial(props.row)"  />
            </q-td>

        </template>
        </q-table>

        </div>


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
      </q-page-container>
    </q-layout>
  </template>
  <script>
  import { defineComponent } from 'vue';
  import {date} from 'quasar';
  export default defineComponent({
  name: 'ConsultaPage',
    props: {
      param: {
        type: String,
        default: ''
      }
    },
    data(){
      return {
        codigo:'',
        dialogHist:false,
        historial:{},
        buscar: {'gestion':date.formatDate(Date.now(),'YYYY'),'oficina':'CU'},
        propietario:{},
        tramites:[],
        tramite:{label:''},
        filter:'',
        filter2:'',
        usuario:'',
        formularios:[],
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
    created(){
      console.log(this.$route.params.codigo )
      let ar=this.$route.params.codigo || ''
      if(ar!='' && ar.length==2){
        this.codigo=ar[0]+'/'+ar[1]
        this.buscarTramite()
      }
      else
        this.codigo=''
      console.log(this.codigo)
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
        getTramites(){
        this.tramites=[]
        this.$api.get('listramite').then((res) => {
          res.data.forEach(r => {
            r.label=r.nombre
            this.tramites.push(r)
          })

        })
      },
      buscarTramite(){
        if(this.codigo==undefined || this.codigo=='')
            return false

         this.$api.post('listForm',{searchtext:this.codigo}).then((res) => {
            this.formularios=[]
            if(res.data==''){
            this.$q.notify({
            message: 'NO EXISTE NINGUN REGISTRO',
            color: 'negative',
            position: 'top',
            icon:'info'
            })}
            else
            this.formularios=res.data

        })
      },

    }
  });
  </script>
  <style >

  </style>
