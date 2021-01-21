import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutGrpCompetenceComponent } from './formulaire-put-grp-competence.component';

describe('FormulairePutGrpCompetenceComponent', () => {
  let component: FormulairePutGrpCompetenceComponent;
  let fixture: ComponentFixture<FormulairePutGrpCompetenceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutGrpCompetenceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutGrpCompetenceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
