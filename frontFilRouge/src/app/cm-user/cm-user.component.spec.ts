import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CmUserComponent } from './cm-user.component';

describe('CmUserComponent', () => {
  let component: CmUserComponent;
  let fixture: ComponentFixture<CmUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CmUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CmUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
