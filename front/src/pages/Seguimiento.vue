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
                <q-btn color="blue" icon="change_circle" size="xs" @click="cambiarUser(props.row)" v-if="store.boolcambio"/>
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
      <q-dialog  v-model="dialogremitir">
            <q-card style="width: 70%; max-width: 80vw;">
              <q-card-section>
                <div class="text-h6"> <q-icon name="outgoing_mail"/> {{ formulario1.codtram }} {{ formulario1.tramite.nombre }} Derivar</div>
              </q-card-section>
              <q-card-section class="q-pt-none">
                <q-form @submit.prevent="registrarlog">
  <!--                <q-select :options="usuarios" label="Seleccionar personal" v-model="usuario" outlined required/>-->
                    <div class="row">
                          <div class="col-12 q-pa-xs">
                            <q-select class="col-8" dense use-input :options="usuarios" label="Seleccionar personal" v-model="usuario" @filter="filterFn" outlined>
                              <template v-slot:no-option>
                                <q-item>
                                  <q-item-section class="text-grey">
                                    Sin resultados
                                  </q-item-section>
                                </q-item>
                              </template>
                              <template v-slot:append>
                                <q-icon name="close" @click.stop.prevent="usuario = ''" class="cursor-pointer" />
                              </template>
                            </q-select>
                          </div>
                        </div>


                  <q-btn label="Cambiar Usuario" color="teal" icon="send" class="full-width" type="submit"/>
                </q-form>
              </q-card-section>
              <q-card-section align="right">
                <q-btn flat label="Cancelar" color="primary" icon="delete" v-close-popup />

              </q-card-section>
            </q-card>
          </q-dialog>
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
        formulario1:{},
        propietario:{},
        tramites:[],
        dialogremitir:false,
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
    created() {
      this.getTramites()
      this.getUser()
    },
    methods:{
      filterFn (val, update) {
        if (val === '') {
          update(() => {
            this.usuarios = this.usuarios2

            // here you have access to "ref" which
            // is the Vue reference of the QSelect
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          this.usuarios = this.usuarios2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
        })
      },

      registrarlog(){
        if(this.usuario.id==undefined)
          return false
        this.$api.post('reasignar',{formulario_id:this.formulario1.id,user_id:this.usuario.id}).then((res) => {
          console.log(res.data)
          this.dialogremitir=false
          this.usuario={label:''}
          this.conLog(this.formulario1)

        })
      },
      getUser(){
        this.usuarios=[]
        this.$api.post('listuser').then((res) => {
          res.data.forEach(r => {
            r.label=r.cargo.nombre + ' ' + r.name
            this.usuarios.push(r)
          })
          this.usuarios2=this.usuarios
        })

      },
      cambiarUser(dato){
        this.formulario1=dato
        this.dialogremitir=true
      },
      envarCambio(){
        if(this.usuario.id==undefined)
          return false
        this.$api.post('reasignar',{id:dato.id,user_id:this.usuario.id}).then((res) => {
          console.log(res.data)
        })
      },
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