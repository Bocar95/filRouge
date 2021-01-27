import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutCompetenceComponent } from './formulaire-put-competence.component';

describe('FormulairePutCompetenceComponent', () => {
  let component: FormulairePutCompetenceComponent;
  let fixture: ComponentFixture<FormulairePutCompetenceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutCompetenceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutCompetenceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
