<template>
    <q-page class="q-pa-sm contenido">
        <q-stepper v-model="tab" flat animated color="indigo" active-color="indigo" style="margin:0; padding:0" >
            <q-step v-for="pr in tramite.procesos" :key="pr.pivot.orden" :name="pr.pivot.orden" :title="pr.nombre" :prefix="pr.pivot.orden" style="min-height: 5px;margin:0; padding:0"/>
        </q-stepper>

    <q-card class="my-card" v-if="formulario!={}" style="font-size: 12px;">
        <q-card-section>
            <div class="text-bold q-pa-xs text-center" style="font-size: 14px;" >DATOS DE TRAMITE : {{ formulario.codigo }} <span style="color:red; font-size: 18px;" v-if="formulario.estado=='RECTIFICAR' || formulario.estado=='CANCELADO'">{{ formulario.estado }}</span></div>
        <div class="row" >
            <div class="col-md-6 col-xs-12"> <b class="q-pa-xs">TRAMITE : </b> {{ tramite.nombre }}</div> 
            <div class="col-md-2 col-xs-4"><b class="q-pa-xs">FECHA ING: </b>{{ formulario.fecha }}</div>
            <div class="col-md-2 col-xs-4" v-if="formulario.distrito!='' || formulario.distrito!=null"><b class="q-pa-xs">DISTRITO :  </b>{{ formulario.distrito }}</div>
            <div class="col-md-2 col-xs-4"><q-btn color="indigo-4" icon="edit_note" label="Observacion" @click="dialogComentario=true" size="sm" v-if="formulario.estado=='EN PROCESO'"><q-tooltip>OPCIONAL Comentario</q-tooltip></q-btn></div>
            <div class="col-md-12 col-xs-12"><b class="q-pa-xs">DETALLE: </b>{{ formulario.detalle }}</div>
        </div>
        </q-card-section>
        </q-card>
        <q-card class="my-card" v-if="formulario!={}" style="font-size: 12px;">
        <q-card-section>
            <div class="text-bold  q-pa-xs text-center" style="font-size: 14px;">DATOS DE PROPIETARIO / GESTOR</div>
    <div class="row">
        <div class="col-md-6 col-xs-12" >
        <div class="text-bold text-center">PROPIETARIO</div>
        <div><b class="q-pa-xs">CARNET : </b>  {{ propietario.cedula }}</div>
        <div><b class="q-pa-xs">NOMBRE :</b> {{ propietario.nombre }} {{ propietario.apellido }} </div>
        <div><b class="q-pa-xs">CELULAR : </b>{{ propietario.celular }}  <q-btn v-if="propietario.celular!=null" @click="sendMessage(propietario.celular)" color="green" size="sm" flat><i class="fa-brands fa-whatsapp" ></i></q-btn></div>
        </div>
        <div class="col-md-6 col-xs-12" v-if="delegado!=null" style="border: 1px solid">
            <div >GESTOR / TRAMITADOR</div>
            <div><b class="q-pa-xs">CEDULA :</b> {{ delegado.cedula }}</div>
            <div><b class="q-pa-xs">NOMBRE :</b> {{ delegado.nombre }} </div>
            <div><b class="q-pa-xs">CELULAR :</b> {{ delegado.celular }} <q-btn v-if="delegado.celular!=null" @click="sendMessage(delegado.celular)" color="green" size="sm" flat><i class="fa-brands fa-whatsapp" ></i></q-btn></div>
        </div>
    </div>
        </q-card-section>
    </q-card>
    <div>
    
     <div class="row">
        <div class="col-6">
            <q-card class="my-card" style="font-size: 12px;">

                <q-card-section>
                    <div class="row text-center">
                   <div class="col-10 text-bold" style="font-size: 14px;">DOCUMENTOS ADJUNTOS</div>
                   <div class="col-1"><q-btn color="indigo" icon="upload"  size="xs" @click="dialogUpload=true"><q-tooltip>SUBIR ARCHIVO PDF</q-tooltip></q-btn></div>
                    </div>
                   <q-table
                    :rows="archivos"
                    :columns="colfile"
                    row-key="name"
                    dense
                   >
                   <template  v-slot:body-cell-op="props">
                <q-td  key="op" :props="props" >
                    <q-btn color="indigo" flat icon="download" size="sm" @click="onDownload(props.row)"/>
             
                </q-td>
            </template>
                   </q-table>
                </q-card-section>
            </q-card>
        </div>
        <div class="col-6">
            <q-card class="my-card">

                <q-card-section>
                   <div class="text-bold text-center" style="font-size: 14px;">RECTIFICADO</div>
                   <q-table
                    :rows="rectificados"
                    :columns="colRect"
                    row-key="name"
                    dense
                   >
                   <template v-slot:body-cell-inicio="props">
                        <q-td key="inicio" :props="props">
                            <span style="color:red; font-size: 18px; font-weight: bold;" v-if="props.row.fin==null">{{ props.row.inicio }}</span>
                            <span v-else>{{ props.row.inicio }}</span>
                        </q-td>
                    </template>
                    <template v-slot:body-cell-dias="props">
                        <q-td key="dias" :props="props">
                            <span style="color:red; font-size: 18px; font-weight: bold;" v-if="props.row.dias>=15">{{ props.row.dias }}</span>
                            <span v-else>{{ props.row.dias }}</span>
                        </q-td>
                    </template>
                   </q-table> 
                </q-card-section>
            </q-card>
        </div>
     </div>
     <q-card class="my-card">
        <q-card-section>
            <div class="row" style="display: flex; justify-content: flex-end">
                <div class="col-md-2" v-if="formulario.estado=='RECTIFICAR'"><q-btn glossy no-caps color="amber-10" icon="question_mark" label="CONTINUAR" @click="dialogCont=true"  dense ><q-tooltip >Regularizado Observacion</q-tooltip></q-btn></div>
                <div class="col-md-2" v-if="tab>1 && formulario.estado=='EN PROCESO'"><q-btn glossy no-caps color="red-7" icon="keyboard_return" label="RECHAZAR" @click="devolver()"  dense ><q-tooltip>Devuelve al anterior</q-tooltip></q-btn></div>
                <div class="col-md-2" v-if="formulario.estado=='EN PROCESO'"><q-btn glossy no-caps color="red-10" icon="archive" label="RECTIFICAR"  @click="observar()" dense> <q-tooltip >Informacion Incompleta o Erronea</q-tooltip></q-btn></div>
                <div class="col-md-2" v-if="derivar=={} && formulario.estado=='EN PROCESO'"><q-btn glossy no-caps color="orange-8" icon="archive" label="FINALIZAR" @click="finalizar()"  dense> <q-tooltip>Ha terminado Correctamente</q-tooltip></q-btn></div>
                <div class="col-md-2" v-if="formulario.estado=='EN PROCESO'">
                    <q-btn-dropdown
                      v-if="derivar!={}"
                        split
                        color="indigo-8"
                        push
                        glossy
                        no-caps
                        icon="send"
                        label="DERIVAR"
                        dense
                        ><q-tooltip>Siguiente Seleccione</q-tooltip>
                        <q-list>
                            <q-item clickable v-close-popup  v-for="v in derivar.usuarios" :key="v" @click="derivarUser(v)">
                            <q-item-section avatar>
                                <q-avatar size="sm" icon="person" color="cyan-3" text-color="white" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label style="font-size: 12px;">{{v.name}}</q-item-label>
                                <q-item-label caption>{{ v.prof }}</q-item-label>
                            </q-item-section>
                            </q-item>


                        </q-list>
                        </q-btn-dropdown>
                </div>
            </div>
        </q-card-section>

        <q-dialog v-model="dialogCont" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <q-avatar icon="quiz" color="red-14" text-color="white" size="sm"/>
                    <span class="q-ml-sm text-h6 text-bold">SE HA CORREGIDO LA OBSERVACION?</span>
                </q-card-section>
                <q-card-section>
                    <q-input v-model="motivo" type="text" label="Cancelado Razon" dense/>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="CERRAR" color="indigo" v-close-popup ><q-tooltip>Cerrar</q-tooltip></q-btn>
                    <q-btn flat label="CANCELAR" color="red" @click="formCancelar" ><q-tooltip>Suspende permanente el tramite </q-tooltip></q-btn>
                    <q-btn flat label="CONTINUAR" color="green" @click="formContinuar" ><q-tooltip>Corregido continua Tramite</q-tooltip></q-btn>
                </q-card-actions>
            </q-card>
        </q-dialog>
     </q-card>

</div>
<br>
    <q-dialog v-model="dialogUpload">
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar icon="signal_wifi_off" color="primary" text-color="white" />
                <span class="q-ml-sm">You are currently not connected to any network.</span>
            </q-card-section>
            <q-card-section>
                <q-input dense v-model="filename" type="text" label="1. Nombre/Descripcion" />
                <label for="">Archivo PDF</label><br>
              <q-uploader
                accept=".pdf"
                @added="getImg"
                auto-upload
                max-files="1"
                label="2. Subir Pdf"
                flat
                max-file-size="5000000"
                @rejected="onRejected"
                bordered
              />
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancelar" color="red" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
    <q-dialog v-model="dialogComentario" >
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar icon="edit_note" color="indigo" text-color="white" size="sm" />
                <span class="q-ml-sm">Agregue Comentario u Observacion</span>
            </q-card-section>
            <q-card-section>
                <q-input v-model="lastLog.obs" type="text" label="Observacion" dense/>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancelar" color="primary" v-close-popup />
                <q-btn flat label="Actualizar" color="amber" @click="agrObservacion" />
            </q-card-actions>
        </q-card>
    </q-dialog>
    </q-page>
</template>
<script>
import moment from 'moment';
export default {
    data() {
        return { 
            filename:'',
            motivo:'',
            archivos:[],
            dialogComentario:false,
            dialogUpload:false,
            dialogCont:false, 
            tab:1,
            propietario:{},  
            delegado:{},  
            rectificados:[],
            tramiteid:this.$route.params.tr,
            id:this.$route.params.id,
            tramite:{},
            formulario:{},
            lastLog:{},
            derivar:{},
            colRect:[
                {label:'FECHA I',name:'inicio',field:'inicio',align:'left'},
                {label:'FECHA F',name:'fin',field:'fin',align:'left'},
                {label:'DIAS',name:'dias',field:'dias',align:'left'},
                {label:'MOTIVO',name:'descripcion',field:'descripcion',align:'left'},
            ],
            colfile:[
                {label:'OP',name:'op',field:'op'},
                {label:'NOMBRE',name:'nombre',field:'nombre',align:'left'},

            ]
            
        }
    },
    mounted(){
        this.$watch(() => this.$route.params,
      (toParams) => {
         console.log(toParams)
        this.id=toParams.id 
        this.tramiteid=toParams.tr
        this.getForm() 
        this.getTramite()
      }
    )
      console.log(this.$route.params)

    },
    created(){
        this.getForm() 
        this.getTramite()
        
    },
    methods:{
        agrObservacion(){
            console.log(this.lastLog)
            this.$api.post('agregarComentario',this.lastLog).then(() => {
                this.dialogComentario=false
            })
        },
        formContinuar(){
            this.$api.put('rectificado/'+this.rectificados[0].id,this.rectificados[0]).then(() => {
                this.$router.push('/asignacion/todo')
            })
        },
        formCancelar(){
            if(this.motivo=='' || this.motivo==undefined){
                this.$q.notify({
                message: 'Debe Ingresar Un Descripcion del Motivo.',
                color: 'red',
                icon:'info'
                })
                return false
            }
            this.$api.post('suspender', {id:this.formulario.id,log_id:this.lastLog.id,motivo:this.motivo}).then(() => {
                this.$q.notify({
                message: 'Tramite Cancelado',
                color: 'red',
                icon:'info'
                })
                this.$router.push('/asignacion/todo')
            })

        },
        finalizar(){
            $q.dialog({
            title: 'FINALIZAR TRAMITE',
            message: 'Ingrese al comentario *',
            prompt: {
                model: '',
                isValid: val => val.length > 2, // << here is the magic
                type: 'text' // optional
            },
            cancel: true,
            persistent: true
            }).onOk(data => {
                this.$api.post('finalizar', {id:this.formulario.id,log_id:this.lastLog.id,motivo:data}).then(() => {
                this.$q.notify({
                message: 'Tramite finalizado',
                color: 'green',
                icon:'info'
                })
                this.$router.push('/asignacion/todo')
            })
            })
        },
        async onDownload(adj){
            try {

        const response = await this.$api.get('download/'+adj.id, { responseType: 'blob' })
        const blob = new Blob([response.data], { type: 'application/pdf' });
                    let pdfUrl = URL.createObjectURL(blob);
                    window.open(pdfUrl,  'download');
         } catch (error) {
               console.error('Error al obtener el PDF', error);
        }
        },
        getAdjuntos(){
            this.$api.post('listAdjunto',{formulario_id:this.formulario.id,proceso_id:this.lastLog.proceso_id}).then(res=>{
                this.archivos=res.data
            })

        },
        getImg(event){
        let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', event[0])
      fd.append('nombre', this.filename)
      fd.append('orden', this.lastLog.orden)
      fd.append('formulario_id', this.formulario.id)
      fd.append('proceso_id', this.lastLog.proceso_id)
        this.$api.post('upload', fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then( () => {
            this.dialogUpload=false
            this.nombre=''
            this.getAdjuntos()
            this.loading=false
          })
          .catch(err => reject(err))
        },
        observar(){
            this.$q.dialog({
                title: 'Observar / Regularizar / Rectificar Tramite',
                message: 'Ingrese el motivo ?',
                prompt: {
                model: '',
                isValid: val => val.length > 2 , // << here is the magic
                type: 'text' // optional
                },
                cancel: true,
                persistent: true
            }).onOk(data => {
                // console.log('>>>> OK, received', data)
                console.log(data)
                this.$api.post('rectificado',{
                orden:this.formulario.latest_log.orden,
                descripcion:data,
                formulario_id:this.formulario.id,
                tramite_id:this.formulario.tramite_id,
                formulario_id:this.formulario.id,
                proceso_id:this.formulario.latest_log.proceso_id
            }).then(() => {
                this.$router.push('/asignacion/todo')
            })
            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
        },
        derivarUser(us){
            this.$api.post('log',{log_id:this.formulario.latest_log.id,
                orden:this.formulario.latest_log.orden,
                tramite_id:this.formulario.tramite_id,
                formulario_id:this.formulario.id,
                user_id:us.id
            }).then(() => {
                this.$router.push('/asignacion/todo')
            })
        },
        devolver(){
            this.$q.dialog({
        title: 'RECHAZAR TRAMITE',
        message: 'Escriba el motivo porque lo devuelve?',
        prompt: {
          model: '',
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        // console.log('>>>> OK, received', data)
        this.formulario.comentario=data
        this.$api.post('rechazar',this.formulario).then(() => {
            //console.log(res.data)
            this.$router.push('/asignacion/todo')
         })
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })

        },
        sendMessage(celular){
            this.$q.dialog({
            title: 'Mensaje Whastapp ',
            message: 'Ingrese Texto',
            prompt: {
            model: '',
            type: 'text' // optional
            },
            cancel: true,
            persistent: true
        }).onOk(data => {
            // console.log('>>>> OK, received', data)
            window.open('https://wa.me/'+celular+'?text='+data, '_blank');
        }).onCancel(() => {
            // console.log('>>>> Cancel')
        }).onDismiss(() => {
            // console.log('I am triggered on both OK and Cancel')
        })
            
            
        },
        onRejected (rejectedEntries) {
            console.log(rejectedEntries)
          this.$q.notify({
            type: 'negative',
            message: `${rejectedEntries.length} el archivo paso las restricciones de validación`
          })
        },
        getTramite(){
         this.$api.get('tramite/'+this.tramiteid).then(res => {
            console.log(res.data)
            this.tramite=res.data
            })
        },
        getForm(){
            this.$api.get('formulario/'+this.id).then(res => {
            console.log(res.data)
            this.formulario=res.data
            console.log(this.formulario)
            this.propietario=this.formulario.propietario
            this.delegado=this.formulario.delegado
            this.rectificados=this.formulario.rectificados
            this.lastLog=this.formulario.latest_log
            console.log(this.lastLog)
            this.tab=this.lastLog.orden
            this.rectificados.forEach(d => {
                d.dias=0
                var start = moment(d.inicio);
                var end = moment();
                if(d.fin==null)
                d.dias=(Math.round(moment.duration(end.diff(start)).asDays()))

            });
            this.getNextProc()
            this.getAdjuntos() 
        })
        },
        getNextProc(){
            this.$api.post('nextProc',{id:this.tramiteid,orden:this.tab}).then(res => {
                console.log(res.data)
                this.derivar=res.data
            })
                
        }

    }
}
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap');
.contenido {
    font-family: 'Almarai', sans-serif;
}
.q-stepper__header--standard-labels .q-stepper__tab {
    min-height: 50px;
    justify-content: center;
}
</style>