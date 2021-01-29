import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { HttpClientModule } from '@angular/common/http';
import { AuthService } from "./service/authService/auth.service";
import { AcceuilComponent } from './acceuil/acceuil.component';
import { UserComponent } from './user/user.component';
import { AdminComponent } from './acceuil/admin/admin.component';
import { FormateurComponent } from './acceuil/formateur/formateur.component';
import { CmComponent } from './acceuil/cm/cm.component';
import { ApprenantComponent } from './acceuil/apprenant/apprenant.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ProfilService } from './service/profilService/profil.service';
import { AuthGuard } from './service/authGuardService/auth.guard';
import { TokenInterceptorProvider } from './service/tokenInterceptorService/token-interceptor.service';
import { VerifyTokenService } from './service/verify-token.service';
import { AngularMaterialModule } from '../material.module';
import { ProfilComponent } from './acceuil/admin/profil/profil.component';
import { AcceuilHeaderComponent } from './acceuil/acceuil-header/acceuil-header.component';
import { AcceuilBodyComponent } from './acceuil/acceuil-body/acceuil-body.component';
import { AcceuilFooterComponent } from './acceuil/acceuil-footer/acceuil-footer.component';
import { AddProfilComponent, DialogOverviewExampleDialog } from './acceuil/admin/profil/add-profil/add-profil.component';
import { ListProfilsComponent } from './acceuil/admin/profil/list-profils/list-profils.component';
import { AdminHeaderComponent } from './acceuil/admin/admin-header/admin-header.component';
import { AdminBodyComponent } from './acceuil/admin/admin-body/admin-body.component';
import { DefaultListProfilsComponent } from './acceuil/admin/profil/default-list-profils/default-list-profils.component';
import { DetailsProfilComponent } from './acceuil/admin/profil/details-profil/details-profil.component';
import { MatTableModule } from '@angular/material/table';
import { MatDialogModule } from '@angular/material/dialog';
import { MatPaginatorModule } from '@angular/material/paginator';
import { NgbModule, NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { AdminUserComponent } from './acceuil/admin/admin-user/admin-user.component';
import { ListAdminComponent } from './acceuil/admin/admin-user/list-admin/list-admin.component';
import { ApprenantUserComponent } from './acceuil/admin/apprenant-user/apprenant-user.component';
import { CmUserComponent } from './acceuil/admin/cm-user/cm-user.component';
import { FormateurUserComponent } from './acceuil/admin/formateur-user/formateur-user.component';
import { FormulaireAddAdminComponent } from './acceuil/admin/formulaires/adminFormulaires/formulaire-add-admin/formulaire-add-admin.component';
import { FormulairePutAdminComponent } from './acceuil/admin/formulaires/adminFormulaires/formulaire-put-admin/formulaire-put-admin.component';
import { ListApprenantComponent } from './acceuil/admin/apprenant-user/list-apprenant/list-apprenant.component';
import { ListFormateurComponent } from './acceuil/admin/formateur-user/list-formateur/list-formateur.component';
import { ListCmComponent } from './acceuil/admin/cm-user/list-cm/list-cm.component';
import { FormulaireAddApprenantComponent } from './acceuil/admin/formulaires/apprenantFormulaires/formulaire-add-apprenant/formulaire-add-apprenant.component';
import { FormulairePutApprenantComponent } from './acceuil/admin/formulaires/apprenantFormulaires/formulaire-put-apprenant/formulaire-put-apprenant.component';
import { FormulaireAddCmComponent } from './acceuil/admin/formulaires/cmFormulaires/formulaire-add-cm/formulaire-add-cm.component';
import { FormulairePutCmComponent } from './acceuil/admin/formulaires/cmFormulaires/formulaire-put-cm/formulaire-put-cm.component';
import { FormulaireAddFormateurComponent } from './acceuil/admin/formulaires/formateurFormulaires/formulaire-add-formateur/formulaire-add-formateur.component';
import { FormulairePutFormateurComponent } from './acceuil/admin/formulaires/formateurFormulaires/formulaire-put-formateur/formulaire-put-formateur.component';
import { GroupeCompetenceComponent } from './acceuil/admin/groupe-competence/groupe-competence.component';
import { ListGrpCompetenceComponent } from './acceuil/admin/groupe-competence/list-grp-competence/list-grp-competence.component';
import { FormulaireAddGrpCompetenceComponent } from './acceuil/admin/formulaires/grpCompetenceFormulaires/formulaire-add-grp-competence/formulaire-add-grp-competence.component';
import { FormulairePutGrpCompetenceComponent } from './acceuil/admin/formulaires/grpCompetenceFormulaires/formulaire-put-grp-competence/formulaire-put-grp-competence.component';
import { DetailsGrpCompetenceComponent } from './acceuil/admin/groupe-competence/details-grp-competence/details-grp-competence.component';
import { CompetencesComponent } from './acceuil/admin/competences/competences.component';
import { ListCompetencesComponent } from './acceuil/admin/competences/list-competences/list-competences.component';
import { DetailsCompetencesComponent } from './acceuil/admin/competences/details-competences/details-competences.component';
import { FormulaireAddCompetenceComponent } from './acceuil/admin/formulaires/competencesFormulaires/formulaire-add-competence/formulaire-add-competence.component';
import { FormulairePutCompetenceComponent } from './acceuil/admin/formulaires/competencesFormulaires/formulaire-put-competence/formulaire-put-competence.component';
import { ReferentielComponent } from './acceuil/admin/referentiel/referentiel.component';
import { ListReferentielComponent } from './acceuil/admin/referentiel/list-referentiel/list-referentiel.component';
import { DetailsReferentielComponent } from './acceuil/admin/referentiel/details-referentiel/details-referentiel.component';
import { FormulaireAddReferentielComponent } from './acceuil/admin/formulaires/referentielFormulaires/formulaire-add-referentiel/formulaire-add-referentiel.component';
import { FormulairePutReferentielComponent } from './acceuil/admin/formulaires/referentielFormulaires/formulaire-put-referentiel/formulaire-put-referentiel.component';
import { PlusDeDetailsRefGrpCompComponent } from './acceuil/admin/referentiel/plus-de-details-ref-grp-comp/plus-de-details-ref-grp-comp.component';



@NgModule({
  declarations: [
    AppComponent,
    ConnexionComponent,
    AcceuilComponent,
    ProfilComponent,
    UserComponent,
    AdminComponent,
    FormateurComponent,
    CmComponent,
    ApprenantComponent,
    AcceuilHeaderComponent,
    AcceuilBodyComponent,
    AcceuilFooterComponent,
    AddProfilComponent,
    ListProfilsComponent,
    AdminHeaderComponent,
    AdminBodyComponent,
    DefaultListProfilsComponent,
    DetailsProfilComponent,
    DialogOverviewExampleDialog,
    AdminUserComponent,
    FormulaireAddAdminComponent,
    ListAdminComponent,
    ApprenantUserComponent,
    CmUserComponent,
    FormateurUserComponent,
    FormulaireAddAdminComponent,
    FormulairePutAdminComponent,
    FormulaireAddApprenantComponent,
    ListApprenantComponent,
    ListFormateurComponent,
    ListCmComponent,
    FormulairePutApprenantComponent,
    FormulaireAddApprenantComponent,
    FormulaireAddCmComponent,
    FormulairePutCmComponent,
    FormulaireAddFormateurComponent,
    FormulairePutFormateurComponent,
    GroupeCompetenceComponent,
    ListGrpCompetenceComponent,
    FormulaireAddGrpCompetenceComponent,
    FormulairePutGrpCompetenceComponent,
    DetailsGrpCompetenceComponent,
    CompetencesComponent,
    ListCompetencesComponent,
    DetailsCompetencesComponent,
    FormulaireAddCompetenceComponent,
    FormulairePutCompetenceComponent,
    ReferentielComponent,
    ListReferentielComponent,
    DetailsReferentielComponent,
    FormulaireAddReferentielComponent,
    FormulairePutReferentielComponent,
    PlusDeDetailsRefGrpCompComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    AppRoutingModule,
    HttpClientModule,
    BrowserAnimationsModule,
    AngularMaterialModule,
    MatTableModule,
    MatDialogModule,
    MatPaginatorModule,
    NgbModule,
    NgbPaginationModule,
  ],
  providers: [
    AuthService,
    AuthGuard,
    ProfilService,
    VerifyTokenService,
    TokenInterceptorProvider
  ],
  bootstrap: [AppComponent]
})

export class AppModule { CUSTOM_ELEMENTS_SCHEMA }