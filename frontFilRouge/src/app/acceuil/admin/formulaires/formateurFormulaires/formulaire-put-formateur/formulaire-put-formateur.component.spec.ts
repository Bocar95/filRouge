import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutFormateurComponent } from './formulaire-put-formateur.component';

describe('FormulairePutFormateurComponent', () => {
  let component: FormulairePutFormateurComponent;
  let fixture: ComponentFixture<FormulairePutFormateurComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutFormateurComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutFormateurComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
