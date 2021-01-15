import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddAdminComponent } from './formulaire-add-admin.component';

describe('FormulaireAddAdminComponent', () => {
  let component: FormulaireAddAdminComponent;
  let fixture: ComponentFixture<FormulaireAddAdminComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddAdminComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddAdminComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
