<template>
    <q-page class="q-pa-xs">

      <div class="row">
        <div class="col-12">
          <q-btn label="Ingresar" icon="folder_open" color="primary" @click="fromcrear" v-if="store.boolregistro"/>
          <q-btn label="Actualizar" icon="refresh" color="amber-5" @click="actualizar" />

          <q-dialog full-width v-model="crear">
            <q-card class="my-card" flat bordered>
              <q-card-section>
                <div class="text-h6" v-if="dato.id==undefined">REGISTRO DE FORMULARIO TRAMITE</div>
                <div class="text-h6" v-else>MODIFICAR DATOS DE TRAMITE</div>
  <!--              <pre>{{dato}}</pre>-->
              </q-card-section>
              <q-card-section >
                <q-form @submit.prevent="guardar">
                  <div class="row" style="border: 1px solid rgba(128,128,128,0.90)">

                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select dense label="TRAMITE" v-model="tramite" :options="tramites" required outlined  /></div>
                    <div class="col-md-2 col-xs-12 q-pa-xs"> <q-input class="inputPrice" required dense label="NUMERO"   type="number"   autofocus  v-model="dato.numero" outlined />                      </div>
                    <div class="col-md-2 col-xs-12 q-pa-xs"><q-input class="inputPrice" dense label="GESTION" v-model="dato.gestion" type="number" required outlined   :rules="[val => val>1900 && val<9999 || 'Ingrese gestion ']"/></div>
                    <div class="col-md-2 col-xs-12 q-pa-xs"><q-select dense label="DISTRITO" v-model="dato.distrito" :options="['','D1','D2','D3','D4','D5','D6']" outlined  /></div>
                    <div class="col-md-12 col-xs-12  q-pa-xs"><q-input dense label="DETALLE" v-model="dato.detalle"  outlined  /></div>
                    <!--<div class="col-md-12 col-xs-12  q-pa-xs"><q-input dense label="Observacion" v-model="dato.observacion"  outlined  /></div> -->
                  </div><br>
                  <div class="row" style="border: 1px solid rgba(128,128,128,0.90)">

                    <div class="col-sm-4 col-xs-6 q-pa-xs"><q-input class="inputPrice" v-model="propietario.cedula" label="NRO CARNET" type="number" dense required outlined @keyup="buscarProp"/></div>
                    <div class="col-sm-4 col-xs-6 q-pa-xs"><q-input v-model="propietario.complemento" type="text" label="COMPLEMENTO" dense  outlined  @keyup="buscarProp" style="text-transform: uppercase;"/></div>
                    <div class="col-sm-6 col-xs-12 q-pa-xs"><q-input v-model="propietario.nombre" type="text" label="Nombres" dense required outlined style="text-transform: uppercase;"/></div>
                    <div class="col-sm-6 col-xs-12 q-pa-xs"><q-input v-model="propietario.apellido" type="text" label="Apellidos" dense required outlined style="text-transform: uppercase;"/></div>
                    <!--<div class="col-sm-12 col-12 q-pa-xs"><q-input v-model="dato.observacion" type="text" label="Observacion" dense outlined/></div>-->
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
              <q-input outlined bottom-slots dense debounce="300" v-model="filter" @keyup.enter="buscar" placeholder="Buscar" @update:modelValue="misdatos">
                <template v-slot:append>
                  <q-icon v-if="filter !== ''" name="close" @click="actualizar" class="cursor-pointer" />
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>

            <!-- opciones de impresion solo para secretaria general -->
            <template v-slot:body-cell-fecha="props">
                <q-td  :props="props">
                  <div class="text-h6"> {{props.row.fecha}}<br>{{props.row.hora}}</div>
                </q-td>
            </template>

            <template v-slot:body-cell-logs="props">
                <q-td  :props="props" style="font-size:10px">
                  <div v-for="s in props.row.logs" :key="s">{{ s.cargo.nombre }} {{ s.fecha }} {{ s.hora }} </div>
                </q-td>
            </template>


            <template v-slot:body-cell-datos="props">
                <q-td  :props="props" style="font-size:10px">
                  <q-btn color="accent" icon="contact_page" @click="informacion=props.row; dialogarchivo=true" dense />
                </q-td>
            </template>

            <template v-slot:body-cell-tramite="props">
                <q-td  :props="props" >
                  {{ props.row.tramite }}
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
                <q-td auto-width key="opciones" :props="props">
                  <template v-if="props.row.estado=='SUSPENDIDO'">
                    <small style="color: red;font-weight: bold">SUSPENDIDO</small>
                  </template>
                  <template v-if="props.row.estado=='FINALIZADO'">
                    <small style="color: green;font-weight: bold">FINALIZADO</small><br>
                    <q-btn class="text-caption" color="blue-grey-6" icon="history" dense label="habilitar" @click="habilitarForm(props.row)" v-if="props.row.estado=='FINALIZADO' && props.row.user_id2==store.user.id"/>
                  </template>
                  <template v-if="(props.row.estado=='PROCESO' || props.row.estado=='SUSPENDIDO') && props.row.user_id2== store.user.id">
                  <q-btn-dropdown color="primary" label="Opciones">
                      <q-list>
                        <q-item clickable v-close-popup @click="cargarMod(props.row) " v-if="props.row.estado=='PROCESO' && props.row.user_id0==store.user.id " >
                          <q-item-section>
                            <q-item-label>MODIFICAR</q-item-label>
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="dialogremitir=true;formulario=props.row; " v-if="props.row.estado=='PROCESO' || props.row.estado=='SUSPENDIDO'" >
                          <q-item-section>
                            <q-item-label>DERIVAR</q-item-label>
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="suspende(props.row)" v-if="props.row.estado=='PROCESO'">
                          <q-item-section>
                            <q-item-label>SUSPENDER</q-item-label>
                          </q-item-section>
                        </q-item>
                        <q-item clickable v-close-popup @click="finaliza(props.row)" v-if="props.row.estado=='PROCESO'">
                          <q-item-section>
                            <q-item-label>FINALIZAR/ENTREGA</q-item-label>
                          </q-item-section>
                        </q-item>

                      </q-list>
                    </q-btn-dropdown>
                  </template>
                  <template v-if="props.row.estado==='PROCESO' && props.row.user_id2!= store.user.id">
                    <small style="color: rgb(100, 0, 128);font-weight: bold">EN PROCESO</small>
                  </template>
                </q-td>
            </template>
            <template v-slot:bottom>
            <div class="full-width flex flex-center">
              <q-pagination
                v-model="current"
                :max="last_page"
                :max-pages="7"
                boundary-numbers
                @update:modelValue="misdatos"
              />
            </div>
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
  import TimeAgo from 'javascript-time-ago'
  import {date} from 'quasar'
import { globalStore } from '../stores/globalStore'
import es from 'javascript-time-ago/locale/es'
import {Printd} from 'printd'
TimeAgo.addDefaultLocale(es)
          const timeAgo = new TimeAgo('es-ES')
  export default {
    name: 'AsignacionPage',
    data(){
      return {
        store: globalStore(),
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
        columns:[
          {name:'opciones',field:'opciones',label:'OPCIONES',align:'right'},
          {name:'codigo',field:'codigo',label:'CODIGO',align:'left'},
          {name:'tramite',field: 'tramite',label:'TRAMITE',align:'left'},
          {name:'distrito',field:'distrito',label:'DISTRITO',align:'left'},
          {name:'cedula',field:'cedula',label:'CEDULA',align:'left'},
          {name:'propietario',field:row=> row.propietario.nombre +' '+row.propietario.apellido,label:'PROPIETARIO',align:'left'},
          {name:'datos',field: 'datos',label:'DATOS',align:'left'},
          {name:'logs',field:'logs',label:'HISTORIAL',align:'left'},
          {name:'dias',field:'dias',label:'DIAS',align:'right'},
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
      console.log('tipo de asignacion:  ',this.tipoasignacion)
    },
    methods:{
      cargarMod(frm){
        this.dato=frm
        this.propietario=frm.propietario
        this.tramite=frm.ftram
        this.tramite.label=this.tramite.nombre
        this.crear=true
        console.log(frm)
        //this.dialogmod=true
      },
      suspende(tr){
        this.$q.dialog({
        title: 'SUSPENDER TRAMITE: '+tr.codigo,
        message: 'registre el motivo?',
        prompt: {
          model: '',
          isValid: val => val.length > 2,
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        // console.log('>>>> OK, received', data)
        tr.observacion=data
        this.$api.post('suspender',tr).then(() => {
          this.misdatos()
        })

      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
      },
      finaliza(tr){
        this.$q.dialog({
        title: 'FINALIZAR TRAMITE: '+tr.codigo,
        message: 'Ingrese alguna observacion',
        prompt: {
          model: '',
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        // console.log('>>>> OK, received', data)
        tr.observacion=data
        this.$api.post('finalizar',tr).then(() => {
          this.misdatos()
        })

      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
      },
      habilitarForm(tr){
        this.$q.dialog({
        title: 'HABILITAR TRAMITE: '+tr.codigo,
        message: 'Ingrese el motivo',
        prompt: {
          model: '',
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        // console.log('>>>> OK, received', data)
        tr.habilita=data
        this.$api.post('habilitar',tr).then(() => {
          this.misdatos()
        })

      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
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
         } else

        this.propietario.complemento = complemento.replace(/\s+/g, '')
          this.$api.post('searchProp',this.propietario).then((res) => {
          console.log(res.data)
          this.propietario.id=res.data.id
          this.propietario.nombre=res.data.nombre
          this.propietario.apellido=res.data.apellido
        })
      },
      getTramites(){
        this.tramites=[]
        this.$api.post('unitTramite').then((res) => {
        console.log(res.data)
          res.data.forEach(r => {
            r.label=r.nombre
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

      registrarlog(){
        // console.log({
        //   mail_id:this.mail.id,
        //   user_id2:this.usuario.id,
        //   destinatario:this.usuario.name,
        //   unit_id:this.usuario.unit_id,
        //   accion:this.miaccion
        // })
        // return false
        // console.log(this.dest);
        if(this.usuario.id==undefined){
          this.$q.notify({
            message:'Debe seleccionar Usuario',
            color:'red',
            icon:'error'
          })
          return false;
        }
        this.$q.loading.show()
        this.$api.post('log',{
          user_id:this.usuario.id,
          formulario_id:this.formulario.id,
          obs:this.observacion
        }).then(() =>{
          // console.log(res.data)
          this.filter=''
          this.usuario={label:''}
          this.observacion=''
          this.misdatos()
          // this.$q.loading.hide()
          this.diaglosasignacion=false
          this.dialogremitir=false
          this.$q.notify({
            message:'Remitido correctamente!!',
            color:'green',
            icon:'done'
          })
        }).catch(err=>{
          this.$q.notify({
            message:err.response.data.message,
            color:'red',
            icon:'error'
          })
          this.$q.loading.hide()
        })
      },


      archivar(mail){
        this.$q.dialog({
          title:'Seguro de archivar?',
           message:'Motivo de archivar (mínimo 4 carácteres)',
           prompt:{
             model:'',
             isValid: val => val.length > 4, // << here is the magic
             type:'text'
           },
          cancel:true,
          persistent: true
        }).onOk(data=>{
          // console.log(mail)
          this.$q.loading.show()
          var today = new Date();
          var now = today.toLocaleString();
          let mensaje = `(${now}): ${data}`
          this.$api.post(process.env.API+'/anulado',{id:mail.id,archivado:mensaje}).then(()=>{
            // console.log(res.data)
            this.misdatos();
            this.$q.notify({
              message: 'Archivado',
              caption: 'Registro archivado',
              color: 'green',
              icon:'done'
            });
          })
        })
      },
      desarchivar(mail){
        this.$q.dialog({
          title:'Seguro de desarchivar?',
           message:'Motivo de desarchivar (mínimo 4 carácteres)',
           prompt:{
             model:'',
             isValid: val => val.length > 4, // << here is the magic
             type:'text'
           },
          cancel:true,
          persistent: true
        }).onOk(data=>{
          // console.log(mail)
          var today = new Date();
          var now = today.toLocaleString();
          let mensaje = `(${now}): ${data}`
          this.$q.loading.show()
          this.$api.post(process.env.API+'/desarchivar',{id:mail.id,desarchivado:mensaje}).then( ()=>{
            // console.log(res.data)
            this.misdatos();
            this.$q.notify({
              message: 'Desarchivado',
              caption: 'Registro desarchivado',
              color: 'green',
              icon:'done'
            });
          })
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
        console.log(this.tipoasignacion)
        this.$api.post('micorreo',{tipoasignacion:this.tipoasignacion,search:this.filter,page:this.current}).then(res=>{
            console.log(res.data)

          this.current= res.data.current_page
          this.last_page= res.data.last_page
          res.data.data.forEach(r=>{
              const dias = timeAgo.format(Date.parse( r.fecha + ' ' + r.hora))
              this.formularios.push({
              id:r.formulario.id,
              codigo:r.formulario.codigo,
              numero:r.formulario.numero,
              cargo:r.cargo.nombre,
              fecha:r.fecha,
              hora:r.hora,
              gestion:r.formulario.gestion,
              distrito:r.formulario.distrito,
              estado:r.formulario.estado,
              tramite:r.formulario.tramite.nombre,
              ftram:r.formulario.tramite,
              propietario:r.formulario.propietario,
              observacion:r.formulario.observacion,
              detalle:r.formulario.detalle,
              cedula:r.formulario.propietario.cedula+(r.formulario.propietario.complemento==''?'':'-'+r.formulario.propietario.complemento),
              user_id0:r.formulario.user_id,
              user_id2:r.user_id2,
              logs:r.formulario.logs,
              dias:dias
          })})
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
            detalle += '<tr><td>'+i+'</td><td style="padding:5px">'+r.detalle+'</td><td></td><td></td></tr>'
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
          <td class='titulo'>GOBIERNO AUTONOMO MUNICIPAL DE ORURO <br>SECRETARIA MUNICIPAL DE GESTIÓN TERRITORIAL</td>
          <td><img src='quir.jpg' width="150px" height='80px'/></td></tr></table>
          <div class='titulo'>CONTROL DE DOCUMENTACION</div>
          <div class='titulo'>`+ tramite.nombre + `</div>
        <table><tr>
          <th style='text-align:left'>NOMBRE:</th><td>`+propie.nombre+' '+propie.apellido +`</td><th>Nº TRAMITE</th></tr>
          <tr><th style='text-align:left'>FECHA:</th><td>`+formulario.fecha  +'</td><td style="text-align:center">'+formulario.codigo+`</td></tr>
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
          console.log(this.dato.id==undefined || this.dato.id=='')
          if(this.dato.id==undefined || this.dato.id==''){
            // console.log('new')
            this.$q.loading.show()
            this.$api.post('formulario',this.dato).then(res=>{
              console.log(res.data)
              this.dato={gestion:date.formatDate(Date.now(),'YYYY')};
              this.filter=''
              this.codigo= res.data.codigo
              this.misdatos()
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
              this.misdatos(this.pagination.page,this.filter,this.pagination.rowsPerPage)
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
