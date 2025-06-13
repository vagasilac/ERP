<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Users list', 'label' => 'Utilizatori/Lista utilizatori', 'order' => '0']);
        Permission::create(['name' => 'Users edit', 'label' => 'Utilizatori/Editare utilizator', 'order' => '0']);
        Permission::create(['name' => 'Users add', 'label' => 'Utilizatori/Adăugare utilizator', 'order' => '0']);
        Permission::create(['name' => 'Users delete', 'label' => 'Utilizatori/Ștergere utilizator', 'order' => '0']);
        Permission::create(['name' => 'Customers list', 'label' => 'Clienți/Lista clienți', 'order' => '0']);
        Permission::create(['name' => 'Customers edit', 'label' => 'Clienți/Editare client', 'order' => '0']);
        Permission::create(['name' => 'Customers add', 'label' => 'Clienți/Adăugare client', 'order' => '0']);
        Permission::create(['name' => 'Customers delete', 'label' => 'Clienți/Ștergere client', 'order' => '0']);
        Permission::create(['name' => 'Suppliers list', 'label' => 'Furnizori/Lista furnizori', 'order' => '0']);
        Permission::create(['name' => 'Suppliers edit', 'label' => 'Furnizori/Editare furnizor', 'order' => '0']);
        Permission::create(['name' => 'Suppliers add', 'label' => 'Furnizori/Adăugare furnizor', 'order' => '0']);
        Permission::create(['name' => 'Suppliers delete', 'label' => 'Furnizori/Ștergere furnizor', 'order' => '0']);
        Permission::create(['name' => 'Roles list', 'label' => 'Roluri/Lista roluri', 'order' => '0']);
        Permission::create(['name' => 'Roles edit', 'label' => 'Roluri/Editare rol', 'order' => '0']);
        Permission::create(['name' => 'Roles add', 'label' => 'Roluri/Adăugare rol', 'order' => '0']);
        Permission::create(['name' => 'Roles delete', 'label' => 'Roluri/Ștergere rol', 'order' => '0']);
        Permission::create(['name' => 'Settings - Materials list', 'label' => 'Setări/Listă materiale', 'order' => '0']);
        Permission::create(['name' => 'Settings - Materials add', 'label' => 'Setări/Adăugare materiale', 'order' => '0']);
        Permission::create(['name' => 'Settings - Materials edit', 'label' => 'Setări/Editare materiale', 'order' => '0']);
        Permission::create(['name' => 'Settings - Materials delete', 'label' => 'Setări/Ștergere material', 'order' => '0']);
        Permission::create(['name' => 'Projects - Projects list', 'label' => 'Proiecte/Lista proiecte/Listare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Projects add', 'label' => 'Proiecte/Lista proiecte/Adăugare proiecte', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit general info', 'label' => 'Proiecte/Informații generale/Editare informații generale', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit datasheet', 'label' => 'Proiecte/Foaie de date/Editare foaie de date', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add drawings', 'label' => 'Proiecte/Desene/Adăugare desene', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit drawings', 'label' => 'Proiecte/Desene/Editare desene', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete drawings', 'label' => 'Proiecte/Desene/Ștergere desene', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit QA drawings', 'label' => 'Proiecte/Desene/Editare desene CTC', 'order' => '0']);
        Permission::create(['name' => 'Projects - Contracts list', 'label' => 'Proiecte/Contracte/Lista contracte', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add contracts', 'label' => 'Proiecte/Contracte/Adăugare contracte', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete contracts', 'label' => 'Proiecte/Contracte/Ștergere contracte', 'order' => '0']);
        Permission::create(['name' => 'Projects - Cuttings list', 'label' => 'Proiecte/Desene/Lista desene de debitare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add cuttings', 'label' => 'Proiecte/Desene/Adăugare desene de debitare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete cuttings', 'label' => 'Proiecte/Desene/Ștergere desene de debitare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Invoices list', 'label' => 'Proiecte/Facturi/Lista facturi', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add invoices', 'label' => 'Proiecte/Facturi/Adăugare facturi', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete invoices', 'label' => 'Proiecte/Facturi/Ștergere facturi', 'order' => '0']);
        Permission::create(['name' => 'Projects - RFQ list', 'label' => 'Proiecte/Cereri de oferte/Lista cereri de oferte', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add RFQ', 'label' => 'Proiecte/Cereri de oferte/Adăugare cerere de ofertă', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete RFQ', 'label' => 'Proiecte/Cereri de oferte/Ștergere cerere de ofertă', 'order' => '0']);
        Permission::create(['name' => 'Projects - Subassemblies list', 'label' => 'Proiecte/Calcul/Lista subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit subassemblies', 'label' => 'Proiecte/Calcul/Editare subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add subassemblies', 'label' => 'Proiecte/Calcul/Adăugare subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete subassemblies', 'label' => 'Proiecte/Calcul/Ștergere subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Subassembly groups list', 'label' => 'Proiecte/Calcul/Lista grupuri de subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit subassembly groups', 'label' => 'Proiecte/Calcul/Editare grupuri de subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add subassembly groups', 'label' => 'Proiecte/Calcul/Adăugare grupuri de subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete subassembly groups', 'label' => 'Proiecte/Calcul/Ștergere grupuri de subansamble', 'order' => '0']);
        Permission::create(['name' => 'Projects - Control plan', 'label' => 'Proiecte/Plan control/Vizualizare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit control plan', 'label' => 'Proiecte/Plan control/Editare plan control', 'order' => '0']);
        Permission::create(['name' => 'Projects - Drawings register', 'label' => 'Proiecte/Desene/Registru desene', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit drawings register', 'label' => 'Proiecte/Desene/Editare registru desene', 'order' => '0']);
        Permission::create(['name' => 'Settings - Standards list', 'label' => 'Setări/Listă standarde', 'order' => '0']);
        Permission::create(['name' => 'Settings - Standards add', 'label' => 'Setări/Adăugare standarde', 'order' => '0']);
        Permission::create(['name' => 'Settings - Standards edit', 'label' => 'Setări/Editare standarde', 'order' => '0']);
        Permission::create(['name' => 'Settings - Standards delete', 'label' => 'Setări/Ștergere standard', 'order' => '0']);
        Permission::create(['name' => 'Projects - Transport files list', 'label' => 'Proiecte/Transport/Lista fișiere transport', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add transport files', 'label' => 'Proiecte/Transport/Adăugare fișiere tranport', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete transport files', 'label' => 'Proiecte/Transport/Ștergere fișiere transport', 'order' => '0']);
        Permission::create(['name' => 'Projects - Edit calculation', 'label' => 'Proiecte/Calcul/Editare calcul', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add calculation materials', 'label' => 'Proiecte/Calcul/Adăugare materiale', 'order' => '0']);
        Permission::create(['name' => 'Projects - Projects delete', 'label' => 'Proiecte/Lista proiecte/Ștergere proiecte', 'order' => '0']);
        Permission::create(['name' => 'IO list', 'label' => 'Registru intrare-ieșire/Listare', 'order' => '0']);
        Permission::create(['name' => 'IO edit', 'label' => 'Registru intrare-ieșire/Editare', 'order' => '0']);
        Permission::create(['name' => 'IO add', 'label' => 'Registru intrare-ieșire/Adăugare', 'order' => '0']);
        Permission::create(['name' => 'IO delete', 'label' => 'Registru intrare-ieșire/Ștergere', 'order' => '0']);
        Permission::create(['name' => 'Projects - Offers list', 'label' => 'Proiecte/Oferta/Vizualizare ofertă', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add offers', 'label' => 'Proiecte/Oferta/Adăugare ofertă', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete offers', 'label' => 'Proiecte/Oferta/Ștergere ofertă', 'order' => '0']);
        Permission::create(['name' => 'Projects - Mails list', 'label' => 'Proiecte/Corespondentă/Vizualizare corespondență', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add mails', 'label' => 'Proiecte/Corespondentă/Adăugare corespondentă', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete mails', 'label' => 'Proiecte/Corespondentă/Ștergere corespondență', 'order' => '0']);
        Permission::create(['name' => 'Projects - Photos list', 'label' => 'Proiecte/Poze/Vizualizare poze', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add photos', 'label' => 'Proiecte/Poze/Adăugare poze', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete photos', 'label' => 'Proiecte/Poze/Ștergere poze', 'order' => '0']);
        Permission::create(['name' => 'Projects - Supply documents list', 'label' => 'Proiecte/Documente/Vizualizare documente aprovizionare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add supply documents', 'label' => 'Proiecte/Documente/Adăugare documente aprovizionare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete supply documents', 'label' => 'Proiecte/Documente/Ștergere documente aprovizionare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Qc documents list', 'label' => 'Proiecte/Documente/Vizualizare documente QC', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add qc documents', 'label' => 'Proiecte/Documente/Adăugare documente QC', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete qc documents', 'label' => 'Proiecte/Documente/Ștergere documente QC', 'order' => '0']);
        Permission::create(['name' => 'Projects - Welding documents list', 'label' => 'Proiecte/Documente/Vizualizare documente sudare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Add welding documents', 'label' => 'Proiecte/Documente/Adăugare documente sudare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Delete welding documents', 'label' => 'Proiecte/Documente/Ștergere documente sudare', 'order' => '0']);
        Permission::create(['name' => 'Machines list', 'label' => 'IMS/Utilaje/Listare', 'order' => '0']);
        Permission::create(['name' => 'Machines edit', 'label' => 'IMS/Utilaje/Editare', 'order' => '0']);
        Permission::create(['name' => 'Machines add', 'label' => 'IMS/Utilaje/Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Machines delete', 'label' => 'IMS/Utilaje/Ștergere', 'order' => '0']);
        Permission::create(['name' => 'Measuring equipments list', 'label' => 'IMS/Echipamente de măsurare/Listare', 'order' => '0']);
        Permission::create(['name' => 'Measuring equipments edit', 'label' => 'IMS/Echipamente de măsurare/Editare', 'order' => '0']);
        Permission::create(['name' => 'Measuring equipments add', 'label' => 'IMS/Echipamente de măsurare/Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Measuring equipments delete', 'label' => 'IMS/Echipamente de măsurare/Ștergere', 'order' => '0']);
        Permission::create(['name' => 'Rulers list', 'label' => 'IMS/Rulete/Listare', 'order' => '0']);
        Permission::create(['name' => 'Rulers edit', 'label' => 'IMS/Rulete/Editare', 'order' => '0']);
        Permission::create(['name' => 'Rulers add', 'label' => 'IMS/Rulete/Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Rulers delete', 'label' => 'IMS/Rulete/Ștergere', 'order' => '0']);
        Permission::create(['name' => 'Requirements analysis view', 'label' => 'Proiecte/Analiza cerinţelor/Vizualizare', 'order' => '0']);
        Permission::create(['name' => 'Coto parties list', 'label' => 'IMS/Contextul Organizației/Listare părți', 'order' => '0']);
        Permission::create(['name' => 'Coto parties edit', 'label' => 'IMS/Contextul Organizației/Editare părți', 'order' => '0']);
        Permission::create(['name' => 'Coto parties add', 'label' => 'IMS/Contextul Organizației/Adăugare părți', 'order' => '0']);
        Permission::create(['name' => 'Coto parties delete', 'label' => 'IMS/Contextul Organizației/Ștergere părți', 'order' => '0']);
        Permission::create(['name' => 'Coto issues list', 'label' => 'IMS/Contextul Organizației/Listare probleme', 'order' => '0']);
        Permission::create(['name' => 'Coto issues edit', 'label' => 'IMS/Contextul Organizației/Editare probleme', 'order' => '0']);
        Permission::create(['name' => 'Coto issues add', 'label' => 'IMS/Contextul Organizației/Adăugare probleme', 'order' => '0']);
        Permission::create(['name' => 'Coto issues delete', 'label' => 'IMS/Contextul Organizației/Ștergere probleme', 'order' => '0']);
        Permission::create(['name' => 'Coto risks register list', 'label' => 'IMS/Contextul Organizației/Listare Registrul riscurilor', 'order' => '0']);
        Permission::create(['name' => 'Coto risks register edit', 'label' => 'IMS/Contextul Organizației/Editare Registrul riscurilor', 'order' => '0']);
        Permission::create(['name' => 'Coto opportunity register list', 'label' => 'IMS/Contextul Organizației/Listare Registrul de oportunități', 'order' => '0']);
        Permission::create(['name' => 'Coto opportunity register edit', 'label' => 'IMS/Contextul Organizației/Editare Registrul de oportunități', 'order' => '0']);
        Permission::create(['name' => 'Capa list', 'label' => 'IMS/Acțiunea preventivă și corectivă Listare', 'order' => '0']);
        Permission::create(['name' => 'Capa edit', 'label' => 'IMS/Acțiunea preventivă și corectivă Editare', 'order' => '0']);
        Permission::create(['name' => 'Capa add', 'label' => 'IMS/Acțiunea preventivă și corectivă Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Capa delete', 'label' => 'IMS/Acțiunea preventivă și corectivă Ștergere', 'order' => '0']);
        Permission::create(['name' => 'Emergency report add', 'label' => 'IMS/Raport privind capacitatea de răspuns la situaţii de urgenţă Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Emergency report edit', 'label' => 'IMS/Raport privind capacitatea de răspuns la situaţii de urgenţă Editare', 'order' => '0']);
        Permission::create(['name' => 'Emergency report verification', 'label' => 'IMS/Raport privind capacitatea de răspuns la situaţii de urgenţă Verificare', 'order' => '0']);
        Permission::create(['name' => 'Emergency report approval', 'label' => 'IMS/Raport privind capacitatea de răspuns la situaţii de urgenţă Aprobare', 'order' => '0']);
        Permission::create(['name' => 'Internal audit add', 'label' => 'IMS/Internal audit Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Internal audit list', 'label' => 'IMS/Internal audit Listare', 'order' => '0']);
        Permission::create(['name' => 'Education list', 'label' => 'Instruire Listare', 'order' => '0']);
        Permission::create(['name' => 'Education add', 'label' => 'Instruire Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Education edit', 'label' => 'Instruire Editare', 'order' => '0']);
        Permission::create(['name' => 'Education trainer list', 'label' => 'Instruire Listare Trainer', 'order' => '0']);
        Permission::create(['name' => 'Machines - view maintenance calendar', 'label' => 'IMS/Utilaje/Vizualizare calendar de mentenanță', 'order' => '0']);
        Permission::create(['name' => 'Projects - Order confirmations list', 'label' => 'Proiecte/Confirmarea comenzii/Listare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Order confirmations add', 'label' => 'Proiecte/Confirmarea comenzii/Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Projects - Order confirmations delete', 'label' => 'Proiecte/Confirmarea comenzii/Ștergere', 'order' => '0']);
        Permission::create(['name' => 'Contract registers list', 'label' => 'IMS/Registrul contractelor Listare', 'order' => '0']);
        Permission::create(['name' => 'Contract registers add', 'label' => 'IMS/Registrul contractelor Adăugare', 'order' => '0']);
        Permission::create(['name' => 'Contract registers edit', 'label' => 'IMS/Registrul contractelor Editare', 'order' => '0']);
        Permission::create(['name' => 'Contract registers delete', 'label' => 'IMS/Registrul contractelor Ștergere', 'order' => '0']);
    }
}
