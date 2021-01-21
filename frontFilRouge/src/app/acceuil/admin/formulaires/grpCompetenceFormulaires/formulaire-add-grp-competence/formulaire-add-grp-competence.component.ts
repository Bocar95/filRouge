import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';

@Component({
  selector: 'app-formulaire-add-grp-competence',
  templateUrl: './formulaire-add-grp-competence.component.html',
  styleUrls: ['./formulaire-add-grp-competence.component.css']
})
export class FormulaireAddGrpCompetenceComponent implements OnInit {

  addingGrpCompetence: FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  descriptifFormControl = new FormControl('', [Validators.required]);
  competenceFormControl = new FormControl();
  competenceList = [];
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private groupeCompetenceService: GroupeCompetenceService,
    private competenceService : CompetenceServiceService
  ) { }

  ngOnInit(): void {
    this.competenceService.getCompetences().subscribe(
      (data : any)=>{
        this.competenceList = data,
        console.log(data)
      });
    this.addingGrpCompetence = this.formBuilder.group({
      libelle : this.libelleFormControl,
      descriptif : this.descriptifFormControl,
      competences : this.competenceFormControl
    });
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/ajouter/groupeCompetence']);
    alert("Ajouter avec success");
  }

  onClickBtnAdd() {
    console.log(this.addingGrpCompetence.value);
    if(this.addingGrpCompetence.value){
      return this.groupeCompetenceService.addGrpCompetence(this.addingGrpCompetence.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      ),this.reloadComponent();
    }
  }

}
