import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { Router, RouterStateSnapshot } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';

@Component({
  selector: 'app-formulaire-put-grp-competence',
  templateUrl: './formulaire-put-grp-competence.component.html',
  styleUrls: ['./formulaire-put-grp-competence.component.css']
})
export class FormulairePutGrpCompetenceComponent implements OnInit {

  grpCompetence = {};
  snapshot: RouterStateSnapshot;
  url;
  id;

  grpCompetenceForm: FormGroup;
  libelleFormControl = new FormControl();
  descriptifFormControl = new FormControl();
  competenceFormControl = new FormControl();
  competenceList = [];
  value;
  
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private grpCompetenceService: GroupeCompetenceService,
    private competenceService : CompetenceServiceService
  ) { }

  ngOnInit(): void {
    this.grpCompetenceService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.grpCompetence = data,
        console.log(data)
      }
    );
    this.competenceService.getCompetences().subscribe(
      (data : any)=>{
        this.competenceList = data,
        console.log(data)
      });
    this.grpCompetenceForm = this.formBuilder.group({
      libelle : this.libelleFormControl,
      descriptif : this.descriptifFormControl,
      competences : this.competenceFormControl
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
    this.router.navigate(['/acceuil/liste/groupeCompetences']);
    alert('Données mofifier avec success');
  }

  onClickBtnValider() {

    if(this.libelleFormControl.value==null){
      this.libelleFormControl.setValue(this.grpCompetence['libelle']);
    }
    if(this.descriptifFormControl.value==null){
      this.descriptifFormControl.setValue(this.grpCompetence['descriptif']);
    }
    if(this.competenceFormControl.value==null){
      this.competenceFormControl.setValue(this.grpCompetence['competences']);
    }
    this.grpCompetenceForm = this.formBuilder.group({
      libelle: this.libelleFormControl,
      descriptif: this.descriptifFormControl,
      competences: this.competenceFormControl
    });

    if(this.grpCompetenceForm.value){
      var id = this.getIdOnUrl();
      return this.grpCompetenceService.putGrpCompetence(id,this.grpCompetenceForm.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      ), this.reloadComponentWithAlert();
    }
  }

}
