<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequisitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('requisitos')->insert([
            ['detalle'=>'Formulario Único de Solicitud de Tramite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FORM 023).','tramite_id'=>1],
            ['detalle'=>'Autorización de Línea y Nivel vigente.','tramite_id'=>1],
            ['detalle'=>'Testimonio de Propiedad y Folio Real debidamente registrado en Derechos Reales (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>1],
            ['detalle'=>'Pago de impuestos de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>1],
            ['detalle'=>'Pago por Tasas y Servicios de las dos últimas gestiones (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>1],
            ['detalle'=>'Plano demostrativo codificado (original).','tramite_id'=>1],
            ['detalle'=>'Cédula de identidad del titular (fotocopia).','tramite_id'=>1],
            ['detalle'=>'Planos Arquitectónicos, debidamente firmado por profesional independiente registrado en el colegio correspondiente (con dos copias).','tramite_id'=>1],
            ['detalle'=>'Planos Sanitarios debidamente firmado por profesional independiente registrado en el colegio correspondiente (con dos copias).','tramite_id'=>1],
            ['detalle'=>'Para construcciones iguales o mayores a tres (3) plantas, planos estructurales con estudio de suelo, memoria de cálculo estructural e hidrosanitario, debidamente firmado por profesional independiente registrado en el colegio correspondiente (con dos copias).','tramite_id'=>1],
            ['detalle'=>'Para construcciones iguales o mayores a tres (3) plantas, deberá presentarse Contrato de Obra entre el propietario y el profesional técnico, o persona jurídica debidamente habilitada para el rubro, responsable de la obra.','tramite_id'=>1],
            ['detalle'=>'Para construcciones iguales o mayores a tres (3) plantas, deberá presentarse Contrato de Supervisión entre el propietario y el profesional técnico, o persona jurídica debidamente habilitada para el rubro, responsable de la supervisión de la obra.','tramite_id'=>1],
            ['detalle'=>'Valores Municipales.','tramite_id'=>1],

            ['detalle'=>'Formulario Único de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM-001 y FORM 023).','tramite_id'=>2],
            ['detalle'=>'Plano Demostrativo en Propiedad Horizontal con corte esquemático (original y fotocopia) firmado por profesional independiente debidamente registrado en el colegio correspondiente.','tramite_id'=>2],
            ['detalle'=>'Testimonio de Propiedad del inmueble con Folio Real y registrado en Derechos Reales, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal Oruro.','tramite_id'=>2],
            ['detalle'=>'Planos arquitectónicos del inmueble, debidamente aprobados por el Gobierno Autónomo Municipal de Oruro.','tramite_id'=>2],
            ['detalle'=>'Testimonio de Propiedad Horizontal del departamento, piso o demás dependencias a ser aprobadas por el Gobierno Autónomo Municipal de Oruro.','tramite_id'=>2],
            ['detalle'=>'Fotocopias del pago de Impuestos a la Propiedad de Bienes Inmuebles y Tasas y Patentes de las dos (2) últimas gestiones, debidamente visadas por la Secretaría Municipal de Asuntos Jurídicos.','tramite_id'=>2],
            ['detalle'=>'Fotocopia de la cédula de identidad del titular','tramite_id'=>2],
            ['detalle'=>'Valores Municipales.','tramite_id'=>2],

            ['detalle'=>'Formulario Único de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FORM 023).','tramite_id'=>3],
            ['detalle'=>'Declaración Jurada ante Notario de Fe Pública, expresando que el terreno a urbanizar no se encuentra en proceso judicial o administrativo y tampoco tiene limitación judicial, constituyéndose el usuario responsable ante la ley de los perjuicios y daños que pudiera ocasionar con su declaración voluntaria.','tramite_id'=>3],
            ['detalle'=>'Fotocopia de Testimonio de Propiedad del inmueble con Folio Real registrado en Derechos Reales, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal Oruro.','tramite_id'=>3],
            ['detalle'=>'En caso de persona jurídica, testimonio poder específico para la realización del presente tramite con una antigüedad en favor del apoderado de máximo tres meses de antigüedad en original, testimonio de constitución de personería jurídica y fotocopia de carnet del apoderado','tramite_id'=>3],
            ['detalle'=>'Fotocopia del pago de Impuestos de Bienes Inmuebles y Tasas y Patentes de las 3 últimas gestiones. (debidamente visado por la Secretaria Municipal de Asuntos Jurídicos).','tramite_id'=>3],
            ['detalle'=>'Fotocopias de cédula de identidad del propietario.','tramite_id'=>3],
            ['detalle'=>'En caso de apoderados deberán presentar Poder Especial y Suficiente en original o fotocopia debidamente legalizada por autoridad competente y una fotocopia de su cédula de identidad del poderdante.','tramite_id'=>3],
            ['detalle'=>'Certificado de Uso de Suelo original o fotocopia legalizada por la Secretaria Municipal de Gestión Territorial, más comprobante de caja original o fotocopia (debidamente visado por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>3],
            ['detalle'=>'Plano Topográfico Georeferenciado aprobado original o fotocopia legalizada por la Secretaria Municipal de Gestión Territorial, más comprobante de caja original o fotocopia (debidamente visado por la Secretaría Municipal de Asuntos Juridicos).','tramite_id'=>3],
            ['detalle'=>'Planos de urbanización completos, debidamente acotados y emplazados en el plano topográfico georreferenciado aprobado, con determinación de aceras, ochaves, anchos de vía, nominación de avenidas, calles, manzanos, predios y otros datos técnicos propios de un plano de urbanización, firmados por profesional arquitecto independiente, en ocho (8) ejemplares, destinados al Usuario, Archivo Técnico, Catastro Urbano, Derechos Reales y E.N.D.E. (mismos que deben estar en escala legible y presentados en papel pliego bond).','tramite_id'=>3],
            ['detalle'=>'Planos Sanitarios, firmados por profesional independiente con 10 ejemplares, destinados al Usuario, Archivo Técnico, Catastro Urbano, Derechos Reales, SeLA y Drenaje Urbano.','tramite_id'=>3],
            ['detalle'=>'Memoria de cálculo hidrosanitario en original y dos copias.','tramite_id'=>3],
            ['detalle'=>'Planos demostrativos y georeferenciados originales de cada una de las áreas verdes, y equipamientos, debidamente identificadas más minuta de trasferencia de las áreas cedidas a favor del Gobierno Autónomo Municipal de Oruro por el o los propietarios de la urbanización (físico y digital) para su registro en oficinas de Derechos Reales, en dos ejemplares.','tramite_id'=>3],
            ['detalle'=>'Plano topográfico de mojones firmado por profesional independiente en tres ejemplares destinados al Usuario y al Gabinete de Topografía de la Entidad.','tramite_id'=>3],
            ['detalle'=>'Memoria de Calculo Hidráulico original, más dos copias.','tramite_id'=>3],
            ['detalle'=>'En formato digital (Cd) se deberá incluir lo siguiente: Plano Topográfico, Plano Arquitectónico de Urbanización en coordenadas reales, Plano Sanitario, Pluvial, de agua potable y tabla de relación de superficies.','tramite_id'=>3],
            ['detalle'=>'Valores Municipales.','tramite_id'=>3],

            ['detalle'=>'Formulario Único de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FORM 023).','tramite_id'=>4],
            ['detalle'=>'Fotocopia del Testimonio de propiedad debidamente registrado en oficinas de Derechos Reales o minuta de transferencia y Testimonio de propiedad del vendedor registrado en oficinas de Derechos Reales de la cual se genera, debidamente visados por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.','tramite_id'=>4],
            ['detalle'=>'Fotocopia de la cédula de identidad del propietario.','tramite_id'=>4],
            ['detalle'=>'Fotocopia legalizada del comprobante de pago del Impuesto a la Propiedad de Bienes Inmuebles y Tasas y Patentes del predio de los tres (3) últimos años.','tramite_id'=>4],
            ['detalle'=>'Plano Topográfico georeferenciado firmado por un profesional independiente debidamente registrado en el colegio correspondiente (tres ejemplares).','tramite_id'=>4],
            ['detalle'=>'Carpeta del proceso de ajustes a la red Geodésica Nacional (un original más dos copias).','tramite_id'=>4],
            ['detalle'=>'Cd que contenga el plano georeferenciado en formato Autocad y los informes de ajuste de redes que incluyan los datos Rinex (3 copias).','tramite_id'=>4],
            ['detalle'=>'Declaración Jurada efectuada ante Notario de Fe Pública, señalando que el terreno a georeferenciar no se encuentra en proceso judicial o administrativo y tampoco tiene limitación judicial, siendo el solicitante responsable ante la Ley de los perjuicios y daños que pudiera ocasionar con su declaración voluntaria.','tramite_id'=>4],
            ['detalle'=>'En caso de contar con un plano topográfico georeferenciado aprobado anterior (de anterior propietario) que cumplió los requisitos, procedimientos respectivos debe ser adjunto el mismo En original o copia legalizada por la Secretaria Municipal de Gestión Territorial a objeto de su verificación técnico legal.','tramite_id'=>4],

            ['detalle'=>'Formulario Único de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 023), debidamente llenado y elevado a declaración jurada','tramite_id'=>5],
            ['detalle'=>'Fotocopia del Testimonio de propiedad debidamente registrado y matriculado en Derecho Reales, con registro catastral, debidamente visado por la Secretaria Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.','tramite_id'=>5],
            ['detalle'=>'Fotocopia del comprobante de pago de Impuesto a la Propiedad de Bienes Inmuebles y tasas por servicios del predio del último año, mismo que deberá estar VISADO por la Dirección de Asuntos Juridicos del G.A.M.O. o certificado negativo de la Unidad de Drenaje Urbano si el caso así lo requiera.','tramite_id'=>5],
            ['detalle'=>'Fotocopia de cédula de identidad del o los propietarios; si el propietario es persona juridica, deberá presentar documentación del representante legal. En caso de que terceras personas y/o apoderado, deberá presentar copia legalizada de poder especifico y suficiente más fotocopia de la cedula de identidad del poderdante','tramite_id'=>5],
            ['detalle'=>'Declaración Voluntaria ante Notario de Fe Pública señalando que el terreno a urbanizar no tiene limitación judicial y no se encuentra cuestionado que posteriormente pudiera resultar en una acción penal o civil, (la apropiación indebida o daño doloso), constituyéndose el solicitante responsable ante la Ley y las instancias ocasionales de los perjuicios y daños que pudiera ocasionar.','tramite_id'=>5],
            ['detalle'=>'Certificado de Uso de Suelo Aprobado original o fotocopia legalizada por Dirección de Ordenamiento Territorial más comprobante de caja original o copia VISADA por la Dirección de Asuntos Juridicos del G.A.M.O','tramite_id'=>5],
            ['detalle'=>'Plano Topográfico-Geo-referenciado Aprobado original o fotocopia legalizada por la Dirección de Ordenamiento Territorial más comprobante de caja por derecho de dicha aprobación original o fotocopia legalizada por la dirección juridica del GAMO','tramite_id'=>5],
            ['detalle'=>'Planos de fraccionamiento completos debidamente acotados y emplazados en Plano Topográfico Georreferenciado aprobado, con determinación de aceras, ochaves anchos de via, nominación de avenidas y calles y otros datos técnicos, firmados por profesional arquitecto independiente (legalmente registrado por el C.A.B y visados por la CAO.) con seis (6) originales, seis (6) copias, destinados 2 al Usuario, 1 Archivo Técnico 1 DDRR, 1 Catastro Urbano, y 1 a ENDE. (Mismo que debe estar en ESCALA LEGIBLE todos los pianos deben ser presentados en papel bond.)','tramite_id'=>5],
            ['detalle'=>'Planos de los sistemas sanitarios, agua potable y pluvial, planos de las estructuras complementarias, firmados por Profesional Ingeniero Civil independiente (Legalmente registrado en el S.I.B.) y visados por el colegio de ingenieros civiles de Oruro (C.I.C.O.), con seis (6) originales, seis (6) copias, destinados 2 al Usuario, 1 Archivo Técnico, 1 Catastro Urbano, 1 Drenaje Urbano y 1 al SeLA, (definir. la acometida de agua potable, la evacuación de las aguas pluviales y aguas servidas). (para predios iguales o mayores a 3000 m2','tramite_id'=>5],
            ['detalle'=>'Memoria de Cálculo hidráulico del sistema sanitario, pluvial, agua potable y sus estructuras complementarias; con dos copias simples (fisico y digital). Debe incluir plano topográfico geo-referenciado, estudio de suelos, plano arquitectónico de la urbanización con coordenadas reales; plano sanitario, pluvial y de agua potable. (para predios iguales o mayores a 3000 m2)','tramite_id'=>5],
            ['detalle'=>'Original de planos demostrativos de cada una de las áreas verdes, equipamientos y vias, debidamente identificadas más minuta de transferencia de las áreas cedidas a favor del Gobierno Autónomo Municipal de Oruro por el o los propietarios de la urbanización (fisico y digital). (conforme estudio técnico urbano','tramite_id'=>5],
            ['detalle'=>'Estudio técnico urbano de respaldo de fraccionamiento y cesión de áreas públicas cumpliendo con las tramas urbanas de su entorno, elaborado por profesional arquitecto independiente (legalmente por el C.A.B.)','tramite_id'=>5],
            ['detalle'=>'Valores Municipales.','tramite_id'=>5],

            ['detalle'=>'Formulario Único de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FORM 23 ).','tramite_id'=>6],
            ['detalle'=>'Plano Demostrativo de Fraccionamiento predial firmado por profesional independiente debidamente registrado en el colegio correspondiente (con dos copias).','tramite_id'=>6],
            ['detalle'=>'Fotocopia del Testimonio de Propiedad que cuente con Folio Real en el registro de Derechos Reales del predio a ser fraccionado, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.','tramite_id'=>6],
            ['detalle'=>'Minuta original de fraccionamiento del predio.','tramite_id'=>6],
            ['detalle'=>'Acta notariada de conformidad de fraccionamiento y división del predio, debidamente firmada por todos los titulares y/o propietarios, que manifiesten su conformidad de ubicación, dimensiones y colindancias.','tramite_id'=>6],
            ['detalle'=>'Fotocopias del Pago de impuestos a la propiedad de Bienes Inmuebles y Tasas y Patentes de la última gestión, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos.','tramite_id'=>6],
            ['detalle'=>'Fotocopia de cédula de identidad de los titulares y beneficiarios de la división o fraccionamiento.','tramite_id'=>6],
            ['detalle'=>'Valores municipales.','tramite_id'=>6],

            ['detalle'=>'Formulario Único de Solicitud de Tramite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FORM 023).','tramite_id'=>7],
            ['detalle'=>'Planos Demostrativos de cada fraccionamiento a ser unificada, firmado por profesional independiente debidamente registrado en el colegio correspondiente. (Deberá adjuntar dos copias).','tramite_id'=>7],
            ['detalle'=>'Plano de unificación firmado por el profesional independiente debidamente registrado en el colegio correspondiente. (Deberá adjuntar dos copias).','tramite_id'=>7],
            ['detalle'=>'Testimonios de Propiedad que cuenten con Folios Reales registrados en Derechos Reales de cada uno de los predios a ser unificados, debidamente visados por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.','tramite_id'=>7],
            ['detalle'=>'Escritura Pública de unificación del predio.','tramite_id'=>7],
            ['detalle'=>'Fotocopias del Pago de Impuestos a la Propiedad de Bienes Inmuebles y Tasas y Patentes de las últimas dos (2) gestiones, debidamente visados por la Secretaría Municipal de Asuntos Jurídicos.','tramite_id'=>7],
            ['detalle'=>'Fotocopia de cédula de identidad del titular de la unificación.','tramite_id'=>7],
            ['detalle'=>'Valores municipales','tramite_id'=>7],

            ['detalle'=>'Formulario Único de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 ).','tramite_id'=>8],
            ['detalle'=>'Fotocopia de Testimonio de propiedad, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.','tramite_id'=>8],
            ['detalle'=>'Fotocopia de la cédula de identidad del propietario.','tramite_id'=>8],
            ['detalle'=>'Fotocopia del comprobante de pago del Impuesto a la Propiedad de Bienes Inmuebles y Tasas y Patentes del predio de los cinco (5) últimos años, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos.','tramite_id'=>8],
            ['detalle'=>'Plano demostrativo original firmado por profesional independiente debidamente registrado en el colegio de profesionales correspondiente. (Con dos copias).','tramite_id'=>8],
            ['detalle'=>'Comprobante de pago de valores y aranceles.','tramite_id'=>8],

            ['detalle'=>'Formulario Único de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FORM 023).','tramite_id'=>9],
            ['detalle'=>'Fotocopia del Testimonio de propiedad debidamente registrado y matriculado en Derecho Reales, con registro catastral, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.','tramite_id'=>9],
            ['detalle'=>'Fotocopia de cédula de identidad del propietario.','tramite_id'=>9],
            ['detalle'=>'Fotocopia del comprobante de pago del Impuesto a la Propiedad de Bienes Inmuebles y Tasas y Patentes del predio de los tres (3) últimos años, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.','tramite_id'=>9],
            ['detalle'=>'Plano Topográfico georeferenciado aprobado por el Gobierno Autónomo Municipal de Oruro, original o fotocopia debidamente legalizado por la Secretaría Municipal de Gestión Territorial. (salvo predios menores a 999,99 m2 los cuales deben presentar plano codificado por la Unidad de Catastro urbano en original).','tramite_id'=>9],
            ['detalle'=>'Comprobante de pago de valores.','tramite_id'=>9],

            ['detalle'=>'Formulario Único de Solicitud de Tramite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FOR 023).','tramite_id'=>10],
            ['detalle'=>'Testimonio de propiedad debidamente matriculado en el registro de Derechos Reales (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>10],
            ['detalle'=>'Pago de impuestos de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>10],
            ['detalle'=>'Pago por Tasas y Servicios de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>10],
            ['detalle'=>'Plano demostrativo codificado (original).','tramite_id'=>10],
            ['detalle'=>'Cédula de identidad del titular (fotocopia).','tramite_id'=>10],
            ['detalle'=>'Valores Municipales.','tramite_id'=>10],

            ['detalle'=>'Formulario Único de Solicitud de Tramite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FOR 023).','tramite_id'=>11],
            ['detalle'=>'Testimonio de propiedad debidamente matriculado en el registro de Derechos Reales (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>11],
            ['detalle'=>'Pago de impuestos de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>11],
            ['detalle'=>'Pago por Tasas y Servicios de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).','tramite_id'=>11],
            ['detalle'=>'Plano demostrativo codificado (original).','tramite_id'=>11],
            ['detalle'=>'Cédula de identidad del titular (fotocopia).','tramite_id'=>11],
            ['detalle'=>'Valores Municipales.','tramite_id'=>11],

        ]);

    }
}
