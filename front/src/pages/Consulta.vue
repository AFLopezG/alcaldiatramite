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
        <div class="col-md-3 col-xs-6 q-pa-xs"> <q-input v-model="buscar.cedula" type="number" label="Numero de Carnet" outlined dense  /> </div>
        <div class="col-md-2 col-xs-4 q-pa-xs"> <q-input  v-model="buscar.complemento" label="Complemento" outlined dense  placeholder="XX" hint="si tiene"  /> </div>
        <div class="col-md-3 col-xs-2">
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
            </q-td>

        </template>
        </q-table>

        </div>
        <div class="q-pa-md" v-if="formulario.id!=undefined">
            <b>TRAMITE: </b> {{ formulario.tramite.nombre }} <br>
            <b>CODIGO: </b> {{ formulario.codigo }} <br>
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
      </q-page-container>
    </q-layout>
  </template>
  <script>
  import { defineComponent } from 'vue';
  import {date} from 'quasar';
  export default defineComponent({
  name: 'ConsultaPage',
    data(){
      return {
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

    methods:{
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
        this.$api.get('listramite').then((res) => {
          res.data.forEach(r => {
            r.label=r.nombre
            this.tramites.push(r)
          })

        })
      },
      buscarTramite(){
        this.formulario=[]
        if(this.buscar.cedula==undefined)
            return false

         this.$api.post('listForm',this.buscar).then((res) => {
          console.log(res.data)
            if(res.data=='')
            this.$q.notify({
            message: 'EL NUMERO DE CARNET NO EXISTE',
            color: 'negative',
            position: 'top',
            icon:'info'
            })
            this.propietario=res.data
            this.formularios=res.data.formularios
            if(this.formularios.length == 0 )
              this.$q.notify({
              message: 'No tiene Tramites Vigentes',
              color: 'negative',
              position: 'top',
              icon:'info'
              })
        })
      },

    }
  });
  </script>
  <style >

  </style>
