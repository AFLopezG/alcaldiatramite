<template>
    <div class="q-pa-md">

      <div class="row">
        <div class="col-6 q-pa-xs"><q-input v-model="fecha" type="date" label="Fecha" dense outlined=""/></div>
        <div class="col-6 q-pa-xs"><q-btn color="info" icon="search" label="Buscar" @click="misdatosDev(); misdatosIng();" /></div>
      </div>

      <q-table dense :filter="filter" title="LISTADO DE TRAMITES DERIVADOS" :rows="reportes2" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
        <template v-slot:top-right>
          <div class="q-pa-xs"><q-btn color="blue-6" icon="print" @click="impresion2" /></div>
          <q-input outlined dense debounce="300" v-model="filter" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>

      </q-table>
      <q-table dense :filter="filter2" title="LISTADO DE TRAMITES INGRESAN" :rows="reportes" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
        <template v-slot:top-right>
          <div class="q-pa-xs"><q-btn color="blue-6" icon="print" @click="impresion" /></div>
          <q-input outlined dense debounce="300" v-model="filter2" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>

      </q-table>
      <br>
      <div class="row">
            <div class="col-3 q-pa-xs"><q-input v-model="fecha3" type="date" outlined dense label="Fecha Ini" /></div>
            <div class="col-3 q-pa-xs"><q-input v-model="fecha4" type="date" outlined dense label="Fecha fin" /></div>


        </div>
        <q-table dense :filter="filter5" title="LISTADO DE TRAMITES FINALIZADOS" :rows="report4" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
        <template v-slot:top-right>
          <div class="q-pa-xs"><q-btn color="amber" icon="search"  @click="reporteFin" /></div>
          <div class="q-pa-xs"><q-btn color="blue-6" icon="print" @click="impresion3" /></div>
          <q-input outlined dense debounce="300" v-model="filter5" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>

      </q-table>
        <div>
          <q-table
            title="Total por tramite"
            :rows="report2"
            row-key="name"
            :filter="filter4"
            >
          <template v-slot:top-right>
            <div class="q-pa-xs"><q-btn color="info" icon="search"  @click="reporteAsignado" /></div>
          <div class="q-pa-xs"><q-btn color="blue-6" icon="print" @click="impresionAsig" /></div>
          <q-input outlined dense debounce="300" v-model="filter4" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        </q-table>
        </div>
        <div >
          <q-table
            title="FORMULARIOS EN PROCESO y SUSPENDIDO POR TRAMITE"
            :rows="report1"
            row-key="name"
            :filter="filter3"
          >
          <template v-slot:top-right>
          <div class="q-pa-xs"><q-btn color="blue-6" icon="print" @click="impresionEstado" /></div>
          <q-input outlined dense debounce="300" v-model="filter3" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        </q-table>
        </div>
      <div id="myelement" class="hidden"></div>

    </div>
  </template>

  <script>
  import { date } from 'quasar'
import {Printd} from 'printd'
import { globalStore } from '../stores/globalStore'
  export default {
    name: 'UserPage',
    data () {
      return {
        alert: false,
        store: globalStore(),
        fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
        fecha3: date.formatDate(new Date(), 'YYYY-MM-DD'),
        fecha4: date.formatDate(new Date(), 'YYYY-MM-DD'),
        ini:'',
        fin:'',
        fecha2:'',
        filter: '',
        filter2: '',
        filter3: '',
        filter4: '',
        filter5: '',
        model: '',
        dato2: {},
        options: [],
        props: [],
        uni: {},
        columns: [
          { name: 'numero', align: 'left', label: 'Nro ', field: 'numero', sortable: true },
          { name: 'tramite', align: 'left', label: 'Tramite', field: 'tramite', sortable: true },
          { name: 'codigo', align: 'left', label: 'Codigo', field: 'codigo', sortable: true },
          { name: 'nombre', align: 'left', label: 'Nombres', field: 'nombre', sortable: true },
          { name: 'apellido', align: 'left', label: 'Apellidos', field: 'apellido', sortable: true },
        ],
        data: [],
        reportes:[],
        reportes2:[],
        report1:[],
        report2:[],
        report4:[]
      }
    },
    created () {
      /* if (!this.$store.state.login.boolusuario){
         this.$router.replace({ path: '/' })
      } */

      this.misdatosIng()
      this.misdatosDev()
      this.reporteEstado()
      this.reporteAsignado()
      this.reporteFin()
    },
    methods: {

      reporteAsignado () {
        if(this.fecha3==undefined || this.fecha4==undefined)
        return false

        this.$q.loading.show()
        this.report2=[]
        this.$api.post('reportAsig',{fecha1:this.fecha3,fecha2:this.fecha4}).then((res) => {
          console.log(res.data)
          this.report2=res.data
          this.$q.loading.hide()
        })
      },

      reporteFin(){
        if(this.fecha3==undefined || this.fecha4==undefined)
        return false

        this.$q.loading.show()
        this.report4=[]
        this.$api.post('reporteFinalizado',{ini:this.fecha3,fin:this.fecha4}).then((res) => {
          console.log(res.data)
          this.ini=this.fecha3
          this.fin=this.fecha4
          let numero=0
          res.data.forEach(r => {
            numero++
            r.numero=numero
            this.report4.push(r)
          })
          this.$q.loading.hide()
        })
      },
      reporteEstado () {
        this.$q.loading.show()
        this.report1=[]
        this.$api.post('reportEstado').then((res) => {
          console.log(res.data)
          this.report1=res.data
          this.$q.loading.hide()
        })
      },
      misdatosIng () {
        if(this.fecha==undefined)
          return false
        this.$q.loading.show()
        this.reportes=[]
        this.$api.post('reporteDiaIng',{fecha:this.fecha}).then((res) => {
          this.fecha2=this.fecha
          console.log(res.data)
          let nro=1
          res.data.forEach(r => {
            r.numero=nro
            nro++
            this.reportes.push(r)
          });
          this.$q.loading.hide()
        })
      },
      misdatosDev () {
        if(this.fecha==undefined)
          return false
        this.$q.loading.show()
        this.reportes2=[]
        this.$api.post('reporteDiaDerv',{fecha:this.fecha}).then((res) => {
          this.fecha2=this.fecha
          console.log(res.data)
          let nro=1
          res.data.forEach(r => {
            r.numero=nro
            nro++
            this.reportes2.push(r)
          });
          this.$q.loading.hide()
        })
      },
      impresion(){
        if(this.reportes.length<=0)
          return false;
        let cadena=`<style>
        .tab1{
          width:100%
        }
        </style> <center>REPORTE DE TRAMITES INGRESAN EN `+this.fecha2+'<br> USUARIO: '+ this.store.user.name+`</center>
        <table class='tab1'>
          <thead><tr><th>NRO</th><th>TRAMITE</th><th>CODIGO</th> <th>NOMBRES</th><th> APELLIDOS</th></tr></tr></thead>
          <tbody>`
          this.reportes.forEach(r => {
            cadena+='<tr><td>'+r.numero+'</td><td>'+r.tramite+'</td><td>'+r.codigo+'</td><td>'+r.nombre+'</td><td>'+r.apellido+'</td></tr>'
          })
        cadena+='</tbody></table>'
        document.getElementById('myelement').innerHTML = cadena
      const d = new Printd()
      d.print( document.getElementById('myelement') )
      },

      impresionAsig(){
        if(this.report2.length<=0)
          return false
        let cadena=`<style>
        .tab1{
          width:100%
        }
      </style> <center>REPORTE DE TRAMITES DERIVADOS EN `+this.fecha3+' AL '+this.fecha4+'<br> USUARIO: '+ this.store.user.name+`</center>
        <table class='tab1'>
          <thead><tr><th>CANTIDAD</th><th>TRAMITE</th></tr></tr></thead>
          <tbody>`
          this.report2.forEach(r => {
            cadena+='<tr><td>'+r.cantidad+'</td><td>'+r.tramite+'</td></tr>'
          })
        cadena+='</tbody></table>'
        document.getElementById('myelement').innerHTML = cadena
      const d = new Printd()
      d.print( document.getElementById('myelement') )
      },
      impresionEstado(){
        if(this.report1.length<=0)
          return false
        let cadena=`<style>
        .tab1{
          width:100%
        }
        </style> <center>REPORTE CANTIDAD DE TRAMITES EN PROCESO O SUSPENDIDO <br>USUARIO: `+ this.store.user.name+`</center>
        <table class='tab1'>
          <thead><tr><th>TRAMITE</th><th>ESTADO</th> <th> TOTAL</th></tr></tr></thead>
          <tbody>`
          this.report1.forEach(r => {
            cadena+='<tr><td>'+r.nombre+'</td><td>'+r.estado+'</td><td>'+r.total+'</td></td></tr>'
          })
        cadena+='</tbody></table>'
        document.getElementById('myelement').innerHTML = cadena
      const d = new Printd()
      d.print( document.getElementById('myelement') )
      },
      impresion2(){
        if(this.reportes2.length<=0)
          return false
        let cadena=`<style>\
        .tab1{\
          width:100%\
        }\
        </style> <center>REPORTE DE TRAMITES DERIVADOS EN `+this.fecha2+'<br> USUARIO: '+ this.store.user.name+`</center>\
        <table class='tab1'>\
          <thead><tr><th>NRO</th><th>TRAMITE</th><th>CODIGO</th> <th>NOMBRES</th> <th> APELLIDOS</th></tr></tr></thead>\
          <tbody>`
          this.reportes2.forEach(r => {
            cadena+='<tr><td>'+r.numero+'</td><td>'+r.tramite+'</td><td>'+r.codigo+'</td><td>'+r.nombre+'</td><td>'+r.apellido+'</td></tr>'
          })
        cadena+='</tbody></table>'
        document.getElementById('myelement').innerHTML = cadena
      const d = new Printd()
      d.print( document.getElementById('myelement') )
      },
      impresion3(){
        if(this.report4.length<=0)
          return false
        let cadena=`<style>
        .tab1{
          width:100%
        }
        </style> <center>REPORTE DE TRAMITES FINALIZADOS EN FECHAS  `+this.ini+' AL '+this.fin+ '<br> USUARIO: '+ this.store.user.name+`</center>
        <br><table class='tab1'>
          <thead><tr><th>NRO</th><th>TRAMITE</th><th>CODIGO</th> <th>NOMBRES</th> <th> APELLIDOS</th></tr></tr></thead>
          <tbody>`
          this.report4.forEach(r => {
            cadena+='<tr><td>'+r.numero+'</td><td>'+r.tramite+'</td><td>'+r.codigo+'</td><td>'+r.nombre+'</td><td>'+r.apellido+'</td></tr>'
          })
        cadena+='</tbody></table>'
        document.getElementById('myelement').innerHTML = cadena
      const d = new Printd()
      d.print( document.getElementById('myelement') )
      }
    }
  }
  </script>
