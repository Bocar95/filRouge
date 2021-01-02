import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DefaultListProfilsComponent } from './default-list-profils.component';

describe('DefaultListProfilsComponent', () => {
  let component: DefaultListProfilsComponent;
  let fixture: ComponentFixture<DefaultListProfilsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DefaultListProfilsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DefaultListProfilsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
