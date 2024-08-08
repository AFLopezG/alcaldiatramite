<template>
    <q-page class="q-pa-xs">
        <div class="text-bold text-center text-h5">LISTADO DE TRAMITES</div>
        <q-table
            :rows="listado"
            :columns="columns"
            row-key="name"
        >
        <template v-slot:top-right>
              <q-btn label="Actualizar" icon="refresh" color="amber-8" @click="getTramite" dense style="padding: 5px;"/>
              <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar" >
                <template v-slot:append>
                  <q-icon v-if="filter !== ''" name="close" @click="actualizar" class="cursor-pointer" />
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            <template v-slot:body-cell-op="props">
                <q-td  :props="props" >
                  <q-btn color="info" icon="change_circle" dense flat  @click="listUser(props.row)" v-if="validaAdmin && (props.row.estado!='FINALIZADO' || props.row.estado!='CANCELADO')"><q-tooltip>CAMBIAR DE USUARIO</q-tooltip></q-btn> 
                  <q-btn color="indigo" icon="timeline" dense flat  @click="getHistorial(props.row)" ><q-tooltip>RUTA DE TRAMITE</q-tooltip></q-btn> 
                  <q-btn color="cyan" icon="description" dense flat  @click="getAdjuntos(props.row)"><q-tooltip>ARCHIVOS ADJUNTOS</q-tooltip></q-btn> 
                </q-td>
            </template>
            <template v-slot:body-cell-estado="props">
                <q-td  :props="props" >
                  <q-badge :color="props.row.estado=='EN PROCESO'?'green':props.row.estado=='RECTIFICAR' || props.row.estado=='CANCELADO'?'red': props.row.estado=='FINALIZADO'?'green':'indigo'" text-color="{2:black}" :label="props.row.estado" />
                </q-td>
            </template>
            <template v-slot:body-cell-dias="props">
                <q-td  :props="props" >
                  <q-badge :color="props.row.dias>0?'red':'amber'" text-color="{2:black}" :label="'Retraso '+props.row.dias+' Dias'" />
                </q-td>
            </template>
        </q-table>
        <q-dialog v-model="dialogCambio" >
            <q-card >
                <q-card-section class="row items-center">
                    <q-avatar icon="people_alt" color="primary" text-color="white" size="sm" />
                    <span class="q-ml-sm">Cambiar de Usuario del Proceso en Curso.</span>
                </q-card-section>
                <q-card-section>
                    <div class="q-pa-xs"><q-select v-model="user" :options="listUsers" label="Usuarios"  option-label="name" outlined dense /></div>
                    <div  class="q-pa-xs"><q-input v-model="motivo" type="text" label="Observacion" dense outlined /></div>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="CANCELAR" color="red" v-close-popup />
                    <q-btn flat label="CAMBIAR" color="amber" @click="regCambio()" />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-dialog v-model="dialogHist" >
            <q-card style="width: 700px; max-width: 100%;">
                <q-card-section class="row items-center">
                    <q-avatar icon="timeline" color="primary" text-color="white" size="sm"   />
                    <span class="q-ml-sm">HISTORIAL DE ENVIOS.</span>
                </q-card-section>
                <q-card-section style="max-height: 60vh" class="scroll">
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
        <q-dialog v-model="dialogfiles" >
            <q-card style="width: 700px; max-width: 80vw;">
                <q-card-section class="row items-center">
                    <q-avatar icon="content_copy" color="primary" text-color="white" size="sm"/>
                    <span class="q-ml-sm">Documentos adjuntos</span>
                </q-card-section>
                <q-card-section>
                    <div class="row" v-for="datos in formulario.tramite.procesos" :key="datos" style="margin:20px">
                        <div class="col-6 text-bold text-right" >{{ datos.nombre }}</div>
                        <div class="col-6 text-center">
                            <div v-for="arch in datos.archivos" :key="arch" style="margin: 10px;">{{ arch.nombre }} <q-btn color="info" flat icon="download" size="xs" @click="onDownload(arch)" /></div>
                        </div>
                        
                    </div>
                    
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="primary" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>
<script>
import moment from 'moment';
import { globalStore } from '../stores/globalStore'

export default {
    name:'listadoPage',
    data() {
        return {
            dialogfiles:false,
            store: globalStore(),
            validaAdmin:false,
            dialogHist:false,
            historial:[],
            motivo:'',
            tramite:{},
            dialogCambio:false,
            listado:[],
            listUsers:[],
            user:{name:''},
            formulario:{},
            filter:'',
            fecha:moment().subtract(60, 'days').format('YYYY-MM-DD'),
            columns:[
                {name:'op',field:'op',label:'op',align:'right'},
                {name:'codigo',field:'codigo',label:'CODIGO',align:'left',sortable:true},
                {name:'estado',field:'estado',label:'ESTADO',align:'left',sortable:true},
                //{name:'tramite',field: row=>row.tramite.nombre,label:'TRAMITE',align:'left',sortable:true},
                {name:'cedula',field:row=>row.propietario.cedula,label:'CEDULA',align:'left',sortable:true},
                {name:'propietario',field:row=> row.propietario.nombre +' '+row.propietario.apellido,label:'PROPIETARIO',align:'left',sortable:true},
                {name:'user',field: row=>row.latest_log.user2.name, label:'Usuario',align:'left',sortable:true},
                {name:'fecha',field: row=>row.latest_log.fecha, label:'FECHA',align:'left',sortable:true},
                {name:'fecha',field: 'fechafin', label:'FECHAF',align:'left',sortable:true},
                {name:'dias',field: 'dias',label:'PLAZO',align:'left'},
            ]
        }
    },
    mounted(){
        this.getTramite()

    },

    created(){
        console.log(this.store.profiles)
        this.validaAdmin=false
        this.store.profiles.forEach( t => {
            if(t.prof=='ADMINISTRADOR') this.validaAdmin=true
        });
    },
    methods:{
        getAdjuntos(frm){
        this.$api.post('formDoc',{id:frm.id}).then((res) => { 
            this.formulario=res.data
            console.log(res.data)
            this.dialogfiles=true
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
        getHistorial(dato){
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
        listUser(dato){
            this.$api.post('listProcUser',{id:dato.latest_log.proceso.id}).then((res) => {                
                console.log(res.data)
                this.listUsers=res.data.usuarios
                this.tramite=dato
                this.dialogCambio=true
            })            
        },
        regCambio(){
            if(this.user.id==undefined)
                return false
            this.$api.post('cambioUserProc',{id:this.tramite.latest_log.id,user_id:this.user.id,motivo:this.motivo}).then(() => { 
                this.dialogCambio=false
                this.motivo=''
                this.user={name:''}   
                this.getTramite()
            })
        },
        getTramite(){
            console.log(this.fecha)
            this.$api.post('listTramite',{fecha:this.fecha}).then((res) => {
                console.log(res.data)
                res.data.forEach(r => {
                    r.fechafin=moment(r.latest_log.fecha +' '+r.latest_log.hora).add(parseInt(r.latest_log.proceso.dias), 'days').format('YYYY-MM-DD')
                    r.dias=(Math.round(moment.duration(moment().diff(r.fechafin)).asDays()))
                    if(r.dias<1 || r.estado=='CANCELADO' || r.estado=='FINALIZADO') r.dias=0
                });
                this.listado=res.data
                console.log(this.listado)
            })
        }
    }
}
</script>