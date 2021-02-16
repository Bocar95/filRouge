import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { Router, RouterStateSnapshot } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';
import { NiveauxService } from 'src/app/service/niveauxService/niveaux.service';

@Component({
  selector: 'app-formulaire-put-competence',
  templateUrl: './formulaire-put-competence.component.html',
  styleUrls: ['./formulaire-put-competence.component.css']
})
export class FormulairePutCompetenceComponent implements OnInit {

  competenceForm: FormGroup;
  libelleFormControl = new FormControl();
  descriptifFormControl = new FormControl();
  niveauCritereEvaluation1FormControl = new FormControl();
  niveauCritereEvaluation2FormControl = new FormControl();
  niveauCritereEvaluation3FormControl = new FormControl();
  niveauGroupeAction1FormControl = new FormControl();
  niveauGroupeAction2FormControl = new FormControl();
  niveauGroupeAction3FormControl = new FormControl();
  id1FormControl = new FormControl();
  id2FormControl = new FormControl();
  id3FormControl = new FormControl();
  value;
  competence = {};
  niveauList = [];
  niveau1 = {};
  niveau2 = {};
  niveau3 = {};
  snapshot: RouterStateSnapshot;
  url;
  id;
  
  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private competenceService : CompetenceServiceService,
    private niveauService : NiveauxService
  ) { }

  ngOnInit(): void {
    this.competenceService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.competence = data,
        this.niveauList = data["niveauCompetences"],
        this.niveau1 = this.niveauList[0],
        this.niveau2 = this.niveauList[1],
        this.niveau3 = this.niveauList[2],
        console.log(data)
      }
    );
    this.competenceForm = this.formBuilder.group({
      libelle : this.libelleFormControl,
      descriptif : this.descriptifFormControl,
      niveauCritereEvaluation1 :this.niveauCritereEvaluation1FormControl,
      niveauCritereEvaluation2 :this.niveauCritereEvaluation2FormControl,
      niveauCritereEvaluation3 :this.niveauCritereEvaluation3FormControl,
      niveauGroupeAction1 : this.niveauGroupeAction1FormControl,
      niveauGroupeAction2 : this.niveauGroupeAction2FormControl,
      niveauGroupeAction3 : this.niveauGroupeAction3FormControl,
      id1 : this.id1FormControl,
      id2 : this.id1FormControl,
      id3 : this.id1FormControl
    });
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[4];
  }

  reloadComponentWithAlert() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/liste/competences']);
    alert('Données mofifier avec success');
  }

  onClickBtnValider() {
    if(this.libelleFormControl.value==null){
      this.libelleFormControl.setValue(this.competence['libelle']);
    }
    if(this.descriptifFormControl.value==null){
      this.descriptifFormControl.setValue(this.competence['descriptif']);
    }
    if(this.niveauCritereEvaluation1FormControl.value==null){
      this.niveauCritereEvaluation1FormControl.setValue(this.niveau1['critereEvaluation']);
    }
    if(this.niveauCritereEvaluation2FormControl.value==null){
      this.niveauCritereEvaluation2FormControl.setValue(this.niveau2['critereEvaluation']);
    }
    if(this.niveauCritereEvaluation3FormControl.value==null){
      this.niveauCritereEvaluation3FormControl.setValue(this.niveau3['critereEvaluation']);
    }
    if(this.niveauGroupeAction1FormControl.value==null){
      this.niveauGroupeAction1FormControl.setValue(this.niveau1['groupeAction']);
    }
    if(this.niveauGroupeAction2FormControl.value==null){
      this.niveauGroupeAction2FormControl.setValue(this.niveau2['groupeAction']);
    }
    if(this.niveauGroupeAction3FormControl.value==null){
      this.niveauGroupeAction3FormControl.setValue(this.niveau3['groupeAction']);
    }
    if(this.id1FormControl.value==null){
      this.id1FormControl.setValue(this.niveau1['id']);
    }
    if(this.id2FormControl.value==null){
      this.id2FormControl.setValue(this.niveau2['id']);
    }
    if(this.id3FormControl.value==null){
      this.id3FormControl.setValue(this.niveau3['id']);
    }
    this.competenceForm = this.formBuilder.group({
      libelle: this.libelleFormControl,
      descriptif: this.descriptifFormControl,
      niveauCritereEvaluation1 :this.niveauCritereEvaluation1FormControl,
      niveauCritereEvaluation2 :this.niveauCritereEvaluation2FormControl,
      niveauCritereEvaluation3 :this.niveauCritereEvaluation3FormControl,
      niveauGroupeAction1 : this.niveauGroupeAction1FormControl,
      niveauGroupeAction2 : this.niveauGroupeAction2FormControl,
      niveauGroupeAction3 : this.niveauGroupeAction3FormControl,
      id1 : this.id1FormControl,
      id2 : this.id2FormControl,
      id3 : this.id3FormControl
    });

    console.log(this.competenceForm.value);
    if(this.competenceForm.value){
      var id = this.getIdOnUrl();
      return this.competenceService.putCompetence(id,this.competenceForm.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      );
    }
  }

}
