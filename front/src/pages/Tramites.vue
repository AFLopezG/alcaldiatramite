<template>
    <q-page class="q-pa-xs">
        <div class="q-gutter-y-md" style="width: 100%">
      <q-tabs
        v-model="tab"
        dense
        class="bg-blue-7 text-white"
        full-width
      >
        <q-tab name="tramite" icon="dashboard_customize" label="Tramites" />
        <q-tab name="requisito" icon="group_work" label="Requisitos" />
        <q-tab name="proceso" icon="account_tree" label="Procesos" />
    </q-tabs>
        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="tramite">
            <div class="text-bold text-center text-h5">LISTADO DE TRAMITES</div>
            <q-table
                :rows="tramites"
                :columns="colTram"
                row-key="name"
                :filter="filtramite"
            >
            <template v-slot:body-cell-requisitos="props">
            <q-td key="requisitos" :props="props">
                <q-btn color="indigo-7" icon="fact_check" dense flat @click="verRequisitos(props.row)" />       
            </q-td>
        </template>
        <template v-slot:body-cell-procesos="props">
            <q-td key="procesos" :props="props">
                <q-btn color="green-6" icon="account_tree" dense flat @click="verProcesos(props.row)" />       
            </q-td>
        </template>
            <template v-slot:body-cell-op="props">
            <q-td key="op" :props="props">
                <q-btn color="yellow" icon="edit" dense flat @click="tramite=props.row;dialogTram=true" />       
                <q-btn color="red" icon="delete" dense flat @click="deleteTram(props.row)" />       
            </q-td>
        </template>
        <template v-slot:top-right>
            <span class="q-pa-xs"><q-btn color="green" icon="check" label="REGISTRAR" @click="tramite={}; dialogTram=true" dense /></span>
              <q-input outlined bottom-slots dense debounce="300" v-model="filtramite" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            </q-table>

          </q-tab-panel>
          <q-tab-panel name="requisito">
            <div class="text-bold text-center text-h5">LISTADO DE REQUISITOS</div>
            <q-table
                :rows="requisitos"
                :columns="colReq"
                row-key="name"
                :filter="filtRequisito"
            >
            <template v-slot:body-cell-op="props">
            <q-td key="op" :props="props">
                <q-btn color="yellow" icon="edit" dense flat @click="requisito=props.row;dialogReq=true" />       
                <q-btn color="red" icon="delete" dense flat @click="deleteReq(props.row)" />       
            </q-td>
        </template>
        <template v-slot:top-right>
            <span class="q-pa-xs"><q-btn color="green" icon="check" label="REGISTRAR" @click="requisito={}; dialogReq=true" dense /></span>
              <q-input outlined bottom-slots dense debounce="300" v-model="filtRequisito" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            </q-table>

          </q-tab-panel>
          <q-tab-panel name="proceso">
            <div class="text-bold text-center text-h5">LISTADO DE PROCESOS  </div>
            <q-table
                :rows="procesos"
                :columns="colProc"
                row-key="name"
                :filter="filtProceso"
            >
            <template v-slot:body-cell-op="props">
            <q-td key="op" :props="props">
                <q-btn color="accent" icon="manage_accounts" dense flat @click="cargarPerfil(props.row)" />       
                <q-btn color="yellow" icon="edit" dense flat @click="proceso=props.row;dialogProc=true" />       
                <q-btn color="red" icon="delete" dense flat @click="deleteProc(props.row)" />       
            </q-td>
        </template>
        <template v-slot:body-cell-profiles="props">
            <q-td key="profiles" :props="props">
            <div v-for="(perfil,index) in props.row.profiles" :key="index">{{ perfil.prof }}</div>
            </q-td>
        </template>
        <template v-slot:top-right>
            <span class="q-pa-xs"><q-btn color="green" icon="check" label="REGISTRAR" @click="proceso={esfuerzo:1,dias:1}; dialogProc=true" dense /></span>
              <q-input outlined bottom-slots dense debounce="300" v-model="filtProceso" placeholder="Buscar">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            </q-table>
          </q-tab-panel>
        </q-tab-panels>

      </div>
      <q-dialog v-model="dialogReq" persistent>
                <q-card style="width: 700px; max-width: 80vw;">
                <q-card-section class="row items-center">
                    <q-avatar icon="list_alt" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm" v-if="requisito.id==undefined"> REGISTRAR REQUISITO</span>
                    <span class="q-ml-sm" v-else>MODIFICAR REQUISITO</span>
                </q-card-section>
                <q-form
                    @submit.prevent="regRequisito"
                    class="q-gutter-md"
                >
                <q-card-section>
                    <q-input v-model="requisito.detalle" type="text" label="Descripcion"  required/>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="red" v-close-popup dense/>
                    <q-btn label="REGISTRAR" type="submit" color="green" dense flat v-if="requisito.id==undefined"/>
                    <q-btn label="MODIFCAR" type="submit" color="yellow" dense flat v-else />
                </q-card-actions>

                </q-form>
                </q-card>
            </q-dialog>
            <q-dialog v-model="dialogProc" persistent>
                <q-card style="width: 700px; max-width: 80vw;">
                <q-card-section class="row items-center">
                    <q-avatar icon="list_alt" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm" v-if="proceso.id==undefined"> REGISTRAR PROCESO</span>
                    <span class="q-ml-sm" v-else>MODIFICAR PROCESO</span>
                </q-card-section>
                <q-form
                    @submit.prevent="regProceso"
                    class="q-gutter-md"
                >
                <q-card-section>
                    <div class="row">
                        <div class="col-12 q-pa-xs"><q-input v-model="proceso.nombre" type="text" label="Nombre" style="text-transform: uppercase;"  required/></div>
                        <div class="col-12 q-pa-xs"><q-input v-model="proceso.descripcion" type="text" label="Descripcion"  required/></div>
                        <div class="col-6 q-pa-xs"><q-input v-model="proceso.esfuerzo" type="number" label="Esfuerzo"  required/></div>
                        <div class="col-6 q-pa-xs"><q-input v-model="proceso.dias" type="number" label="Dias"  required/></div>
                    </div>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="red" v-close-popup dense/>
                    <q-btn label="REGISTRAR" type="submit" color="green" dense flat v-if="proceso.id==undefined"/>
                    <q-btn label="MODIFCAR" type="submit" color="yellow" dense flat v-else />
                </q-card-actions>

                </q-form>
                </q-card>
            </q-dialog>

    <q-dialog v-model="dialogPerfil">
        <q-card style="width: 700px;max-width: 80vw">
          <q-card-section class="bg-info">
            <div class="text-h7 text-white"><q-icon name="folder"/>ACTUALIZAR PERFILES</div>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="updateperfil">
              <!--          v-on:click.native="updatepermiso(permiso)"-->
              <q-checkbox style="width: 100%"  v-for="(perfil,index) in perfiles" :key="index" :label="perfil.prof" v-model="perfil.estado" />
              <!--          <q-form>-->
              <!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
              <!--          </q-form>-->
              <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-dialog v-model="dialogTram" persistent>
                <q-card style="width: 700px; max-width: 80vw;">
                <q-card-section class="row items-center">
                    <q-avatar icon="list_alt" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm" v-if="tramite.id==undefined"> REGISTRAR TRAMITE</span>
                    <span class="q-ml-sm" v-else>MODIFICAR TRAMITE</span>
                </q-card-section>
                <q-form
                    @submit.prevent="regTramite"
                    class="q-gutter-md"
                >
                <q-card-section>
                    <div class="row">
                        <div class="col-6 q-pa-xs"><q-input v-model="tramite.codigo" type="text" label="Codigo"  required/></div>
                        <div class="col-12 q-pa-xs"><q-input v-model="tramite.nombre" type="text" label="Nombre" style="text-transform: uppercase;"  required/></div>
                        <div class="col-12 q-pa-xs"><q-input v-model="tramite.descripcion" type="text" label="Descripcion"  required/></div>
                        <div class="col-12 q-pa-xs"><q-select v-model="unit" :options="unidades" label="Unidad" option-label="nombre" @filter="filterFn" use-input input-debounce="0" >
                            <template v-slot:no-option>
                            <q-item>
                                <q-item-section class="text-grey">
                                No results
                                </q-item-section>
                            </q-item>
                            </template>
                        </q-select></div>
                    </div>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="red" v-close-popup dense/>
                    <q-btn label="REGISTRAR" type="submit" color="green" dense flat v-if="tramite.id==undefined"/>
                    <q-btn label="MODIFCAR" type="submit" color="yellow" dense flat v-else />
                </q-card-actions>

                </q-form>
                </q-card>
            </q-dialog>

            <q-dialog v-model="dialogTRequisito" persistent full-width>
                <q-card >
                <q-card-section class="row items-center">
                    <q-avatar icon="list_alt" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm">GESTIONAR REQUISITOS<br>{{ tramite.nombre }}</span>
                </q-card-section>
                <q-form
                    
                    class="q-gutter-md"
                >
                <q-card-section>
                    <div class="row">
                        <div class="col-11 q-pa-xs"><q-select dense v-model="campoReq" :options="requisitos" label="Requisito" option-label="detalle" @filter="filterReq" use-input input-debounce="0" >
                            <template v-slot:no-option>
                            <q-item>
                                <q-item-section class="text-grey">
                                No results
                                </q-item-section>
                            </q-item>
                            </template>
                        </q-select></div>
                        <div class="col-1"><q-btn flat color="green" icon="add_circle_outline" @click="agRequisito" ><q-tooltip>AGREGAR REQUISITO</q-tooltip></q-btn></div>
                    </div>
                    <div v-for="(rq,index) in tramite.requisitos" :key="index" style="font-size: 12px;">
                        <q-btn flat size="sm" color="red" icon="delete"  @click="borrarReq(rq)" />{{rq.detalle}}
                    </div>

                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="red" v-close-popup dense/>
                </q-card-actions>
                </q-form>
                </q-card>
            </q-dialog>
            <q-dialog v-model="dialogTProceso" persistent full-width>
                <q-card >
                <q-card-section class="row items-center">
                    <q-avatar icon="list_alt" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm">GESTIONAR PROCESO<br>{{ tramite.nombre }}</span>
                </q-card-section>
                <q-form
                    
                    class="q-gutter-md"
                >
                <q-card-section>
                    <div class="row">
                        <div class="col-8 q-pa-xs"><q-select dense v-model="campoProc" :options="procesos" label="Procesos" option-label="nombre" @filter="filterProc" use-input input-debounce="0" >
                            <template v-slot:no-option>
                            <q-item>
                                <q-item-section class="text-grey">
                                No results
                                </q-item-section>
                            </q-item>
                            </template>
                        </q-select></div>
                        <div class="col-3 q-pa-xs"><q-input dense v-model="orden" type="number" label="N Orden"/></div>
                        <div class="col-1"><q-btn flat color="green" icon="add_circle_outline" @click="agProceso" ><q-tooltip>AGREGAR PROCESO</q-tooltip></q-btn></div>
                    </div>
                    <div v-for="(pr,index) in tramite.procesos" :key="index" style="font-size: 12px;">
                        <q-btn flat size="sm" color="red" icon="delete"  @click="borrarProc(pr)" />{{pr.pivot.orden}} : {{pr.nombre}}
                    </div>

                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="red" v-close-popup dense/>
                </q-card-actions>
                </q-form>
                </q-card>
            </q-dialog>

    </q-page>
</template>
<script>
export default {
    name:'tramitePage',
    data() {
        return {
            tab:'tramite',
            orden:0,
            filtRequisito:'',
            filterProceso:'',
            campoReq:{detalle:''},
            campoProc:{nombre:''},
            filtProceso:'',
            filtramite:'',
            tramites:[],
            procesos:[],
            requisitos:[],
            frequisito:[],
            fproceso:[],
            tramite:{},
            proceso:{esfuerzo:1,dias:1},
            requisito:{},
            perfiles:[],
            dialogTram:false,
            dialogProc:false,
            dialogReq:false,
            dialogPerfil:false,
            dialogTRequisito:false,
            dialogTProceso:false,
            unidades:[],
            funit:[],
            unit:{nombre:''},
            colReq:[
                {label:'OP',name:'op',field:'op'},
                {label:'DETALLE',name:'detalle',field:'detalle',align:'left'},
            ],
            colProc:[
                {label:'OP',name:'op',field:'op'},
                {label:'NOMBRE',name:'nombre',field:'nombre'},
                {label:'DESCRIPCION',name:'descripcion',field:'descripcion'},
                {label:'ESFUERZO',name:'esfuerzo',field:'esfuerzo'},
                {label:'DIAS',name:'dias',field:'dias'},
                {label:'PERFILES',name:'profiles',field:'profiles'},
            ],
            colTram:[
                {label:'OP',name:'op',field:'op'},
                {label:'UNIDAD',name:'unidad',field:row=>row.unit.nombre,align:'left'},
                {label:'CODIGO',name:'codigo',field:'codigo',align:'left'},
                {label:'NOMBRE',name:'nombre',field:'nombre',align:'left'},
                {label:'REQUISITOS',name:'requisitos',field:'requisitos',align:'left'},
                {label:'PROCESOS',name:'procesos',field:'procesos',align:'left'},
            ],
        }
    },
    created(){
        this.getTramites()
        this.getProcesos()
        this.getRequisitos()
        this.getPerfiles()
        this.getUnit()
    },
    methods:{
        borrarReq(req){            
           console.log(req)
           this.$q.dialog({
                title: 'Confirmar',
                message: 'Seguro de eliminar requisito?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                // console.log('>>>> OK')
                this.$api.post('retirarRequisito',req.pivot).then((res) => {
                console.log(res)
                this.buscarTramite(this.tramite.id) 
            })
            }).onOk(() => {
                // console.log('>>>> second OK catcher')
            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
        },
        borrarProc(req){            
           console.log(req)
           this.$q.dialog({
                title: 'Confirmar',
                message: 'Seguro de eliminar proceso?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                // console.log('>>>> OK')
                this.$api.post('retirarProceso',req.pivot).then((res) => {
                console.log(res)
                this.buscarTramite(this.tramite.id) 
            })
            }).onOk(() => {
                // console.log('>>>> second OK catcher')
            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
        },
        agRequisito(){
            if(this.campoReq.id==undefined)
                return false

            this.$api.post('agregarRequisito',{tramite_id:this.tramite.id,requisito_id:this.campoReq.id}).then(() => {
                this.buscarTramite(this.tramite.id) 
            })
            
        },
        agProceso(){
            if(this.orden < 0)
                return false
            if(this.campoProc.id==undefined)
                return false
            this.$api.post('agregarProceso',{tramite_id:this.tramite.id,proceso_id:this.campoProc.id,orden:this.orden}).then(() => {
                this.buscarTramite(this.tramite.id) 
            })
            
        },
        filterReq(val, update) {
            if (val === '') {
          update(() => {
            this.requisitos = this.frequisito
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          this.requisitos = this.frequisito.filter(v => v.detalle.toLowerCase().indexOf(needle) > -1)
        })
        },
        filterProc(val, update) {
            if (val === '') {
          update(() => {
            this.procesos = this.fproceso
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          this.procesos = this.fproceso.filter(v => v.nombre.toLowerCase().indexOf(needle) > -1)
        })
        },
        filterFn (val, update) {
        if (val === '') {
          update(() => {
            this.unidades = this.funit
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          this.unidades = this.funit.filter(v => v.nombre.toLowerCase().indexOf(needle) > -1)
        })
      },
        buscarTramite(d){
            this.$api.get('tramite/'+d).then((res) => {
            console.log(res.data)
                this.tramite=res.data
                let valor = 0

                this.tramite.procesos.forEach(r=> {
                    if(r.pivot.orden > valor)
                        valor = r.pivot.orden                
                });

                
                this.orden =  valor + 1
        })
        },
        verRequisitos(r){
            this.buscarTramite(r.id)
            this.dialogTRequisito=true
        },
        verProcesos(r){
            this.buscarTramite(r.id)
  
            this.dialogTProceso=true
        },
        updateperfil(){
            this.$api.put('upPerfilProc/'+this.proceso.id,{perfiles:this.perfiles}).then((res) => {
                console.log(res.data)
                this.dialogPerfil=false
                this.getProcesos()
            })

        },
        cargarPerfil (i) {
        // console.log(i.row)
        this.dialogPerfil = true
        this.proceso = i
        let p
        this.perfiles.forEach(pe => {
          // console.log(pe);
          p = this.proceso.profiles.find(r => r.pivot.profile_id === pe.id)
          // console.log(p)
          if (p !== undefined) { pe.estado = true } else { pe.estado = false }
          // console.log(p)
        })
      },
      getUnit(){
            this.$api.get('unit').then((res) => {
                console.log(res.data)
                this.unidades=res.data
                this.funit=res.data
            })
        },
        getRequisitos(){
            this.$api.get('requisito').then((res) => {
                console.log(res.data)
                this.requisitos=res.data
                this.frequisito=res.data
            })
        },
        getProcesos(){
            this.$api.get('proceso').then((res) => {
                console.log(res.data)
                this.procesos=res.data
                this.fproceso=res.data
            })
        },
        getTramites(){
            this.$api.get('tramite').then((res) => {
            console.log(res.data)
                this.tramites=res.data
            })
        },
        getPerfiles(){
            this.$api.get('profile').then((res) => {
                this.perfiles=[]
                res.data.forEach(r => {
                    r.estado=false
                    this.perfiles.push(r)
                });
            })
        },
        regRequisito(){
            if(this.requisito.id==undefined){
            this.$api.post('requisito',this.requisito).then(() => {
                this.dialogReq=false
                this.requisito={}
             this.getRequisitos()
        }).catch(err => {
            console.log(err)
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
        }
        else{
            this.$api.put('requisito/'+this.requisito.id,this.requisito).then(() => {
                this.dialogReq=false
                this.requisito={}
             this.getRequisitos()
        })
        }
        },
        regProceso(){
            if(this.proceso.id==undefined){
            this.$api.post('proceso',this.proceso).then(() => {
                this.dialogProc=false
                this.proceso={}
             this.getProcesos()
        }).catch(err => {
            console.log(err)
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
        }
        else{
            this.$api.put('proceso/'+this.proceso.id,this.proceso).then(() => {
                this.dialogProc=false
                this.proceso={}
             this.getProcesos()
        })
        }
        },
        regTramite(){
            if(this.unit.id==undefined)
                return false
            this.tramite.unit_id=this.unit.id
            if(this.tramite.id==undefined){
            this.$api.post('tramite',this.tramite).then(() => {
                this.dialogTram=false
                this.tramite={}
             this.getTramites()
        }).catch(err => {
            console.log(err)
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
        }
        else{
            this.$api.put('tramite/'+this.tramite.id,this.tramite).then(() => {
                this.dialogTram=false
                this.tramite={}
             this.getTramites()
        })
        }
        },
        deleteReq(p){   
        this.$q.dialog({
                title: 'Confirmar',
                message: 'Esta Seguro de Eliminar?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                this.$api.delete('requisito/'+p.id).then(() => {
                    this.getRequisitos()
                })

            }).onOk(() => {
                // console.log('>>>> second OK catcher')
            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
      
        },
        deleteProc(p){   
        this.$q.dialog({
                title: 'Confirmar',
                message: 'Esta Seguro de Eliminar?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                this.$api.delete('proceso/'+p.id).then(() => {
                    this.getProcesos()
                })

            }).onOk(() => {
                // console.log('>>>> second OK catcher')
            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
      
        },
        deleteTram(p){   
        this.$q.dialog({
                title: 'Confirmar',
                message: 'Esta Seguro de Eliminar?',
                cancel: true,
                persistent: true
            }).onOk(() => {
                this.$api.delete('tramite/'+p.id).then(() => {
                    this.getTramites()
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
    computed:{
        maxOrden(){
            let valor = 0

            this.tramite.procesos.forEach(r=> {
                if(r.pivot.orden > valor)
                    valor = r.pivot.orden                
            });

            return valor + 1
        }
    }
}
</script>