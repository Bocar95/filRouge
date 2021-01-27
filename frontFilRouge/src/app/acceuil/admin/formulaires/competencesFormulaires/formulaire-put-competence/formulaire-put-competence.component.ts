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

  competence = {};
  snapshot: RouterStateSnapshot;
  url;
  id;

  competenceForm: FormGroup;
  libelleFormControl = new FormControl();
  descriptifFormControl = new FormControl();
  niveauCompetencesFormControl = new FormControl();
  niveauList = [];
  value;
  
  btnText = 'Ajouter';

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
        console.log(data)
      }
    );
    this.niveauService.getNiveaux().subscribe(
      (data : any)=>{
        this.niveauList = data,
        console.log(data)
      });
    this.competenceForm = this.formBuilder.group({
      libelle : this.libelleFormControl,
      descriptif : this.descriptifFormControl,
      niveauCompetences : this.niveauCompetencesFormControl
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
    if(this.niveauCompetencesFormControl.value==null){
      this.niveauCompetencesFormControl.setValue(this.competence['niveauCompetences']);
    }
    this.competenceForm = this.formBuilder.group({
      libelle: this.libelleFormControl,
      descriptif: this.descriptifFormControl,
      niveauCompetences: this.niveauCompetencesFormControl
    });

    if(this.competenceForm.value){
      var id = this.getIdOnUrl();
      return this.competenceService.putCompetence(id,this.competenceForm.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      ), this.reloadComponentWithAlert();
    }
  }

}
