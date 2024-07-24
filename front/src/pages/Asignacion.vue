<template>
    <q-page class="q-pa-xs">

      <div class="row">
        <div class="col-12">
          <q-btn label="Ingresar" icon="folder_open" color="primary" @click="fromcrear" v-if="store.boolregistro"/>
          

          <q-dialog full-width v-model="crear">
            <q-card class="my-card" flat bordered>
              <q-card-section>
                <div class="text-h6" v-if="dato.id==undefined">REGISTRO DE FORMULARIO TRAMITE</div>
                <div class="text-h6" v-else>MODIFICAR DATOS DE TRAMITE</div>
  <!--              <pre>{{dato}}</pre>-->
              </q-card-section>
              <q-card-section >
                <q-form @submit.prevent="guardar">
                  <div class="row" >
                    <div class="col-md-6 col-xs-12 q-pa-xs">
                      <div class="row " style="border: 1px solid rgba(128,128,128,0.90)">
                    <div class="col-12 text-bold text-center">DATOS DE TRAMITE</div><br>
                      <div class="col-md-12 col-xs-12 q-pa-xs"><q-select dense label="TRAMITE" v-model="tramite" :options="tramites" required outlined  /></div>
                      <div class="col-md-4 col-xs-12 q-pa-xs"> <q-input class="inputPrice" required dense label="NUMERO"   type="number"   autofocus  v-model="dato.numero" outlined />                      </div>
                      <div class="col-md-4 col-xs-12 q-pa-xs"><q-input class="inputPrice" dense label="GESTION" v-model="dato.gestion" type="number" required outlined   :rules="[val => val>1900 && val<9999 || 'Ingrese gestion ']"/></div>
                      <div class="col-md-4 col-xs-12 q-pa-xs"><q-select dense label="DISTRITO" v-model="dato.distrito" :options="['','D1','D2','D3','D4','D5','D6']" outlined  /></div>
                      <div class="col-md-12 col-xs-12  q-pa-xs"><q-input dense label="DETALLE" v-model="dato.detalle"  outlined  /></div>
                  </div>
                  <div class="row " style="border: 1px solid rgba(128,128,128,0.90)">
                    <div class="col-12 text-bold text-center">REQUISITOS</div>
                      <ul><li v-for="rq in tramite.requisitos " :key="rq">{{ rq.detalle }}</li> </ul>
                    </div>
                    </div>
                    <div class="col-md-6 col-xs-12 q-pa-xs" >

                  <div class="row" style="border: 1px solid rgba(128,128,128,0.90)">
                    <div class="col-12 text-bold text-center">DATOS DE TRAMITADOR</div><br>
                      <div class="col-md-6 col-xs-12 q-pa-xs">
                        <q-input style="text-transform: uppercase;" dense label="Gestor CI" v-model="delegado.cedula"  outlined list="gestores" name="myBrowser" @update:model-value="cambio" />
                      <datalist id="gestores">
                        <option v-for="r in gestores" :key="r.gestorci">{{r.cedula}}</option>
                      </datalist>
                    </div>
                      <div class="col-md-6 col-xs-12 q-pa-xs">
                        <q-input class="inputPrice" dense label="Gestor Celular" v-model="delegado.celular"  outlined  type="number"/>

                      </div>
                    <div class="col-md-12 col-xs-12 q-pa-xs"><q-input style="text-transform: uppercase;" dense label="Gestor Nombre" v-model="delegado.nombre"  outlined  /></div>
                    <!--<div class="col-md-12 col-xs-12  q-pa-xs"><q-input dense label="Observacion" v-model="dato.observacion"  outlined  /></div> -->
                    </div>
                    <br>
                  <div class="row" style="border: 1px solid rgba(128,128,128,0.90)">
                    <div class="col-12 text-bold text-center">DATOS DE CLIENTE *</div><br>
                    <div class="col-sm-4 col-xs-6 q-pa-xs"><q-input class="inputPrice" v-model="propietario.cedula" label="NRO CARNET*" type="number" dense required outlined @keyup="buscarProp"/></div>
                    <div class="col-sm-2 col-xs-6 q-pa-xs"><q-input v-model="propietario.complemento" type="text" label="COMP" dense  outlined  @keyup="buscarProp" style="text-transform: uppercase;"/></div>
                    <div class="col-sm-6 col-xs-6 q-pa-xs"><q-input class="inputPrice" v-model="propietario.celular" type="number" label="CELULAR" dense  outlined  /></div>
                    <div class="col-sm-6 col-xs-12 q-pa-xs"><q-input v-model="propietario.nombre" type="text" label="Nombres *" dense required outlined style="text-transform: uppercase;"/></div>
                    <div class="col-sm-6 col-xs-12 q-pa-xs"><q-input v-model="propietario.apellido" type="text" label="Apellidos *" dense required outlined style="text-transform: uppercase;"/></div>
                  </div>
                </div>
                </div>

                    <div class="col-sm-2 col-12 q-pa-xs flex flex-center">
                      <q-btn type="submit" color="primary" icon="add_circle" label="Registrar" v-if="dato.id==undefined || dato.id==''" dense/>
                      <q-btn type="submit" color="amber" icon="edit" label="Modificar" v-else dense/>
                    </div>
                </q-form>

              </q-card-section>

              <q-card-actions align="right">
                <q-btn flat label="Cerrar" icon="delete" color="primary" v-close-popup />
              </q-card-actions>
            </q-card>
          </q-dialog>
        </div>
        <div class="col-12">
          <q-table
            dense
            title="LISTA DE TRAMITES"
            :rows="formularios"
            :columns="columns"
            :filter="filter"
            :loading="loading"
            row-key="name"
          >
            <template v-slot:top-right>
              <q-btn label="Actualizar" icon="refresh" color="amber-8" @click="actualizar" dense style="padding: 5px;"/>
              <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon v-if="filter !== ''" name="close" @click="actualizar" class="cursor-pointer" />
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>

            <!-- opciones de impresion solo para secretaria general -->


            <template v-slot:body-cell-datos="props">
                <q-td  :props="props" style="font-size:10px">
                  <q-btn color="accent" icon="contact_page" @click="informacion=props.row; dialogarchivo=true" dense />
                </q-td>
            </template>

            <template v-slot:body-cell-tramite="props">
                <q-td  :props="props" >
                  {{ props.row.tramite.nombre }}
                  <br>
                  <q-btn size="xs" color="blue" flat label="Requisitos" @click="impresion(props.row.id)" />
                </q-td>
            </template>


            <template v-slot:body-cell-codigo="props">
                <q-td  :props="props" >
                  {{ props.row.codigo }}
                  <br>
                  <q-btn size="xs" color="green" flat label="Hoja Ruta" @click="impRuta(props.row.id)" />
                </q-td>
            </template>

            <template  v-slot:body-cell-opciones="props">
                <q-td auto-width key="opciones" :props="props" style="text-align:center">
                    <q-btn color="amber" icon="edit" flat size="sm" @click="modificar(props.row)" v-if="props.row.latest_log.user_id==null"><q-tooltip >MODIFICAR DATOS</q-tooltip></q-btn>
                    <q-btn color="indigo" flat icon="file_open" dense :to="'/vertramite/'+props.row.id+'/'+props.row.tramite.id" v-if="props.row.estado=='EN PROCESO' || props.row.estado=='RECTIFICAR'"/>
                    <div :style="'font-weight: bold;font-size: 10px; color:'+props.row.color" >{{ props.row.estado }}</div>
              
                </q-td>
            </template>

          </q-table>

          <q-dialog v-model="diaglosasignacion">
            <q-card style="width: 700px; max-width: 80vw;">
              <q-card-section>
                <div class="text-h6"> <q-icon name="outgoing_mail"/> {{formulario.tramite.nombre}} | Remitir</div>
              </q-card-section>
              <q-card-section class="q-pt-none">
                <q-form @submit.prevent="registrarlog">
                  <q-input type="textarea" style="text-transform: uppercase" outlined label="Instruccion / Observacion" v-model="miaccion" required/>
  <!--                <q-select :options="usuarios" label="Seleccionar personal" v-model="usuario" outlined required/>-->
                  <q-select dense use-input :options="usuarios" label="Seleccionar personal" v-model="usuario" @filter="filterFn" outlined >
                    <template v-slot:no-option>
                      <q-item>
                        <q-item-section class="text-grey">
                          Sin resultados
                        </q-item-section>
                      </q-item>
                    </template>
                  </q-select>
                  <q-btn color="positive"  label="Agregar Destinatario" icon="add_circle" @click="tabdest"/>
                  <q-list dense bordered padding class="rounded-borders">
                    <q-item clickable v-ripple v-for="(row,index) in dest" :key="index">
                      <q-item-section class="q-pa-none text-subtitle2" >
                        {{index+1}} {{row.name}}
  <!--                      <pre>{{row}}</pre>-->
                      </q-item-section >
                      <q-item-section class="q-pa-none text-subtitle2">
                        {{row.unit.nombre}}
                      </q-item-section>
                      <q-item-section class="q-pa-none text-subtitle2">
                        <q-btn @click="quitardestinatario(index)" icon="delete" color="negative" flat />
                      </q-item-section>
                    </q-item>
                  </q-list>
  <!--                {{mail}}-->
                  <q-btn label="Remitir" color="teal" icon="send" class="full-width" type="submit"/>
                </q-form>
              </q-card-section>
              <q-card-section align="right">
                <q-btn flat label="Cancelar" color="primary" icon="delete" v-close-popup />

              </q-card-section>
            </q-card>
          </q-dialog>


          <q-dialog  v-model="dialogremitir">
            <q-card style="width: 70%; max-width: 80vw;">
              <q-card-section>
                <div class="text-h6"> <q-icon name="outgoing_mail"/>{{ formulario.codigo }} {{ formulario.tramite }} Derivar</div>
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
                          <div class="col-12 q-pa-xs"><q-input v-model="observacion" type="text" label="Observacion" outlined dense /></div>
                        </div>


                  <q-btn label="Remitir" color="teal" icon="send" class="full-width" type="submit"/>
                </q-form>
              </q-card-section>
              <q-card-section align="right">
                <q-btn flat label="Cancelar" color="primary" icon="delete" v-close-popup />

              </q-card-section>
            </q-card>
          </q-dialog>

          <q-dialog v-model="dialogarchivo" full-width>
            <q-card >
              <q-card-section>
                <div class="text-h6"> <q-icon name="list"/> Datos de Formulario</div>
              </q-card-section>
              <q-card-section class="q-pt-none">
                <div><b>Codigo: </b> {{ informacion.codigo}} <b>Tramite: </b> {{ informacion.tramite}}</div>
                <div><b>Propietario: </b> {{ informacion.propietario.nombre }} {{ informacion.propietario.apellido }} <b> Cedula :</b> {{ informacion.cedula}} {{ informacion.complemento }}</div>
                <div><b>Estado: </b> {{ informacion.estado}}</div>
                <div><b>Detalle: </b>{{ informacion.detalle}}</div>
                <div><b>Observacion: </b>{{ informacion.observacion}}</div>
              </q-card-section>
              <q-card-section align="right">
                <q-btn flat label="Cancelar" color="primary" icon="delete" v-close-popup />
              </q-card-section>
            </q-card>
          </q-dialog>

        </div>
      </div>
  <div id="myelement" class="hidden"></div>

    </q-page>
  </template>

  <script>
import {date} from 'quasar'
import { globalStore } from '../stores/globalStore'
import {Printd} from 'printd'
import TimeAgo from 'javascript-time-ago'
import es from 'javascript-time-ago/locale/es'

  export default {
    name: 'AsignacionPage',
    data(){
      return {
        store: globalStore(),
        delegado:{},
        propietario:{},
        observacion:'',
        remitir:{},
        tramites:[],
        tramite:{label:''},
        tipoasignacion:this.$route.params.tipoasignacion,
        destinatario:'',
        destinatarios:'',
        crear:false,
        miaccion:'',
        filter:'',
        usuario:'',
        diaglosasignacion:false,
        dialogremitir:false,
        dialogarchivo:false,
        dialogmod:false,
        formulario2:{},
        url:process.env.API,
        dato:{tipo:'',fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),folio:1},
        //folios:[],
        usuarios:[],
        usuarios2:[],
        mails:[],
        mail:{},
        // log:{},
        remitentes:[],
        remitentes2:[],
        informacion:{},
        remitente:'',
        cargo:'',
        institucion:'',
        codigo:'',
        dest:[],
        contadorcreadosignorados:0,
        tipodoc:null,
        derivaciones: [],
        dialogayudaremitir:false,
        gestores:[],
        columns:[
          {name:'opciones',field:'opciones',label:'OPCIONES',align:'right'},
          {name:'codigo',field:'codigo',label:'CODIGO',align:'left'},
          {name:'tramite',field: row=>row.tramite.nombre,label:'TRAMITE',align:'left'},
          {name:'distrito',field:'distrito',label:'DISTRITO',align:'left'},
          {name:'cedula',field:row=>row.propietario.cedula,label:'CEDULA',align:'left'},
          {name:'propietario',field:row=> row.propietario.nombre +' '+row.propietario.apellido,label:'PROPIETARIO',align:'left'},
          {name:'fecha',field: row=>row.latest_log.fecha, label:'FECHA',align:'left'},
          {name:'datos',field: 'datos',label:'DATOS',align:'left'},
          {name:'dias',field: 'dias',label:'PLAZO',align:'left'},
        ],
        pagination:{
          // sortBy: 'name',
        // descending: false,
          page:1,
          rowsPerPage: 3,
          rowsNumber: 0
        },
        formularios:[],
        formulario:{},
        loading:false,
        current:1
      }
    },
    computed:{
    },
    mounted(){
      this.$watch(() => this.$route.params,
      (toParams) => {
        // console.log(previousParams)
        this.tipoasignacion = toParams.tipoasignacion

         this.misdatos()
      }
    )
    },
    created() {

      this.misdatos()
      this.getTramites()
      this.getUser()
      this.getGestor()
      console.log('tipo de asignacion:  ',this.tipoasignacion)
    },
    methods:{
      cambio(){
      this.delegado.nombre=''
      this.delegado.celular=''
       //onsole.log(this.dato.gestorci)
      this.gestores.find(r=>{ 
        if (r.cedula===this.delegado.cedula){
          // console.log(r.cargo)
          this.delegado.nombre=r.nombre
          this.delegado.celular=r.celular
          return false
        }else{
          // this.cargo=''
          // this.institucion=''
        }
      })
    },
      getGestor(){
        this.$api.get('delegado').then((res) => {
          console.log(res.data)
          this.gestores=[]
          this.gestores=res.data
        })

      },
      cargarMod(frm){
        this.dato=frm
        this.propietario=frm.propietario
        this.tramite=frm.ftram
        this.tramite.label=this.tramite.nombre
        this.crear=true
        console.log(frm)
        //this.dialogmod=true
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
      buscarProp(){
        console.log(this.propietario)

        let cedula=this.propietario.cedula
        let complemento=this.propietario.complemento
        if((cedula).length <= 5)
          return false
        this.propietario.cedula = cedula.replace(/\s+/g, '')
        if(this.propietario.complemento == undefined)
        {this.propietario.complemento=null
         this.propietario.id=null
          this.propietario.nombre=null
          this.propietario.apellido=null
          this.propietario.celular=null
         } else{

        this.propietario.complemento = complemento.replace(/\s+/g, '')
      }
          this.$api.post('searchProp',this.propietario).then((res) => {
          console.log(res.data)
          this.propietario.id=res.data.id
          this.propietario.nombre=res.data.nombre
          this.propietario.apellido=res.data.apellido
          this.propietario.celular=res.data.celular
          console.log(this.propietario)
        })
      },

      getTramites(){
        this.tramites=[]
        this.$api.post('unitTramite').then((res) => {
        console.log(res.data)
          res.data.forEach(r => {
            r.label=r.nombre
            if(r.procesos.length > 0)
            this.tramites.push(r)
          })
        })
      },
      fromcrear(){
        console.log('ini')
        this.dato={gestion:date.formatDate(Date.now(),'YYYY')}
        this.crear = true
      },
      modificar(prop){
        console.log(prop)
        this.crear=true;
        this.dato=prop;
        if(this.dato.delegado!=null) 
          this.delegado=this.dato.delegado
        else 
          this.delegado={}
        this.propietario=this.dato.propietario
        this.tramite=this.dato.tramite
        this.tramite.label=this.tramite.nombre
      },
      quitardestinatario(i){
        this.dest.splice(i,1)
      },
      tabdest(){
        let verif=false;
        this.dest.forEach(element => {
          if(element.listuser.id==this.usuario.id)
            verif=true;
        });
        if(!verif && this.usuario!='')
          this.dest.push({
            listuser:this.usuario,
            instruccion: '',
            tipodoc:'',
            nfojas:'',
            observacion:''
            });
            console.log(this.dest)
      },
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


      archivo(mail){
        console.log(mail)
        this.mail=mail
        this.dialogarchivo=true
      },

      actualizar(){
          this.filter=''
          this.misdatos()
      },
      misdatos(){
        this.formularios=[]
        //this.$q.loading.show()
        this.loading=true
        this.$api.post('micorreo',{estado:this.tipoasignacion}).then(res=>{
            console.log(res.data)
          TimeAgo.addDefaultLocale(es)
          const timeAgo = new TimeAgo('es-ES')
          res.data.forEach(r => {
            const dias = timeAgo.format(Date.parse( r.latest_log.fecha + ' ' + r.latest_log.hora))
            r.dias=dias
            r.color='black'  
              if(r.estado=='EN PROCESO') r.color='green'
              if(r.estado=='CANCELADO'||r.estado=='RECTIFICAR') r.color='red'
              if(r.estado=='FINALIZADO') r.color='indigo'
              
          });
          this.formularios=res.data
          this.loading=false
          this.$q.loading.hide()
          console.log(this.formularios)
        })
      },

      handleRequest(props){
          console.log('halderesquest: ',props)
          if(props.pagination.rowsPerPage===0){
            props.pagination.rowsPerPage=this.pagination.rowsNumber
          }
          this.misdatos(props.pagination.page,props.filter,props.pagination.rowsPerPage)
      },
      impresion(id){
        this.$api.get('/printReq/'+id).then((res)=>{
          console.log(res.data)
          let tramite= res.data.tramite
          let propie= res.data.propietario
          let formulario=res.data
          let detalle=''
          let i=0
          if(tramite.requisitos.length<=0)
            return false
          tramite.requisitos.forEach(r => {
            i++
            detalle += '<tr><td>'+i+'</td><td class="contenido" style="padding:5px">'+r.detalle+'</td><td></td><td></td></tr>'
          });
          let cadena = `<html><style>
        .cuerpo{
            padding: 0px;
            margin: 0px;
            margin-left: 5px;
            border: 0px;}
        table{
                width:100%;
                border-collapse: collapse;
              }
              .contenido{
                font-size:12px
              }
              .titulo{
              text-align:center;
              font-weight:bold;
              }
         .tabla > tr,td {
                border:1px solid;
            }
        </style>
        <body class='cuerpo'>
        <table><tr><td style='width:20%'><img src='escudo.jpg' width="100px" height='100px'/></td>
          <td class='titulo'>GOBIERNO AUTONOMO MUNICIPAL DE ORURO <br>`+ tramite.unit.nombre + `</td>
          <td><img src='quir.jpg' width="150px" height='80px'/></td></tr></table>
          <div class='titulo'>CONTROL DE DOCUMENTACION</div>
          <div class='titulo'>`+ tramite.nombre + `</div>
        <table><tr>
          <th style='text-align:left'>NOMBRE:</th><td>`+propie.nombre+' '+propie.apellido +`</td><th>Nº TRAMITE</th></tr>
          <tr><th style='text-align:left'>FECHA:</th><td>`+formulario.fecha  +'</td><td style="text-align:center">'+formulario.codtram+`</td></tr>
          <tr><td colspan=3>`+formulario.detalle  +`</td></tr>
        </table>
        <table class='tabla'>
          <tr><th style='width:5%'>No</th><th style='width:80%'>REQUISITOS</th><th style='width:5%'>SI</th><th style='width:5%'>NO</th></tr>
          `+ detalle +`
        </table>
        </body>
        </html> `
          document.getElementById('myelement').innerHTML = cadena
      const d = new Printd()
      d.print( document.getElementById('myelement') )
      }
       )
    },
      impRuta(id){
        this.$api.get('/printRuta/'+id).then((res)=>{
          if(res.data!=''){
          document.getElementById('myelement').innerHTML = res.data
      const d = new Printd()
      d.print( document.getElementById('myelement') )
          }
      }
        )
      },
      buscar(){
        //handleRequest()
        console.log('filter:',this.filter)
        this.misdatos(this.pagination.page,this.filter,this.pagination.rowsPerPage)
      },
      anular(mail){
        this.$q.dialog({
          title:'Seguro de anular?',
          message:'Motivo de anular',
          prompt:{
            model:'',
            type:'text'
          },
          cancel:true,
        }).onOk(data=>{
          // console.log(data)
          this.$q.loading.show()
          this.$api.post(process.env.API+'/anulado',{mail_id:mail.id,accion:data,estado:'ANULADO'}).then(()=>{
            this.misdatos();
            this.$q.notify({
              message: 'Anulado',
              caption: 'Registro anulado',
              color: 'green',
              icon: 'done'
            })
          })
        })
      },
      guardar(){
        if (this.tramite.id==undefined || this.tramite.id==''){
          this.$q.notify({
            message:'Porfavor Seleccione el tramite',
            color:'red',
            icon:'error'
          })
          return false
        }
        this.$q.dialog({
          title:'Seguro de registrar?',
          // message:"",
          cancel:true,
          persistent:true
        }).onOk(()=>{
          console.log(this.dato)
          this.$q.loading.show()
          if(this.propietario.complemento==undefined) 
          this.propietario.complemento=''
          this.dato.tramite_id=this.tramite.id
          this.dato.propietario=this.propietario
          this.dato.delegado=this.delegado
          console.log(this.dato.id==undefined || this.dato.id=='')
          if(this.dato.id==undefined || this.dato.id==''){
            // console.log('new')
            this.$q.loading.show()
            this.$api.post('formulario',this.dato).then(res=>{
              console.log(res.data)
              this.dato={gestion:date.formatDate(Date.now(),'YYYY')};
              this.propietario={}
              this.delegado={}
              this.filter=''
              this.codigo= res.data.codigo
              this.misdatos()
              this.getGestor()
              this.crear=false
              this.$q.loading.hide()
            }).catch(error=>{
              console.log('error',error)
              this.$q.loading.hide()
              this.$q.notify({
                message:error,
                color:'red',
                icon:'error'
              })
            })
            //console.log("datos fuera de axios",this.codigo)

            }
          else{
            this.$q.loading.show()
            this.$api.post('/updateform',this.dato).then(()=>{
              this.dato={gestion:date.formatDate(Date.now(),'YYYY')};
              this.crear=false
              this.misdatos()
              this.getGestor()
            }).catch(err=>{
              console.log(err)
              this.$q.notify({
                message:err,
                color:'red',
                icon:'error'
              })
              this.$q.loading.hide()
            })
          }
        })

      },

    }
  }
  </script>

  <style  scoped>
  .my-card{
  width: 100%;
  max-width: 250px;}
  .inputPrice >>> input[type="number"] {
  -moz-appearance: textfield;
    }
    .inputPrice >>> input::-webkit-outer-spin-button,
    .inputPrice >>> input::-webkit-inner-spin-button {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
    }
  </style>
